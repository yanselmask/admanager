## Context

El panel público de miembros vive en el plugin `member`: guard `member`, rutas `public.member.*` bajo `/account`, vistas en `platform/themes/<tema activo>/views/member/dashboard/` con su propio layout maestro (tema activo: `moreno`), y menú lateral registrado con `DashboardMenu::for('member')`. `PublicController@getDashboard` resuelve **un** dominio por `member_id` y calcula tarjetas leyendo las columnas JSON de `domains`.

Los datos de Google Ad Manager los ingiere `Botble\Admanager\Services\Admanager`: descarga un reporte por network code, lo vuelca a CSV y escribe `earnings/impressions/clicks/ctrs/ecpms` en `domains`, indexados por clave de periodo. Los importes vienen en **micros** (dividir entre 1.000.000). Las networks disponibles están en el setting `admanager_networks` (repeater `code`/`name`).

El partner es un actor comercial distinto del creador: no aporta un dominio, aporta **networks enteras**. Necesita ver el agregado de sus networks con su porcentaje aplicado, sin ver cifras brutas ni datos de creadores.

Restricción de peso: el plugin `member` es código de Botble adaptado. Cuanto menos lo modifiquemos, más barato será actualizarlo.

## Goals / Non-Goals

**Goals:**
- Encapsular todo lo del partner en `platform/plugins/partner/`, con **cero modificaciones** al plugin `member` y al plugin `domain`.
- Reutilizar guard, sesión, login, KYC y layout del panel de miembros.
- Cálculo de ganancias explícito, testeable y aislado en un servicio, sin el ciclo formatear→parsear que hoy usa `PublicController`.
- No alterar en nada el comportamiento del panel de creadores.

**Non-Goals:**
- Cambiar la ingesta de Ad Manager o el esquema de `domains`.
- Facturación, pagos, registro público de partners, API. (Ver «No incluido» en `proposal.md`.)

## Decisions

### D1 — Rol como columna en `members`, no guard propio

`members.role` (`string(20)`, default `creator`, indexada) + `members.commission` (`decimal(12,2)` nullable).

*Por qué:* reutiliza login, sesión, verificación de email, KYC, perfil, avatar y layout sin duplicar nada. Un guard propio obligaría a clonar todo el flujo de autenticación.

*Alternativa descartada:* tabla `partners` con `member_id`, donde «ser partner» se deriva de la existencia del registro. Evita la columna, pero convierte cada comprobación de rol en un JOIN y complica la degradación a creador. Se descarta por legibilidad.

*Mass assignment:* NO se toca `$fillable` de `Member`. El formulario de administración asigna `$member->role` y `$member->commission` por propiedad y llama a `save()`, lo que no pasa por el guard de asignación masiva.

### D2 — Relaciones inyectadas, no editadas

`PartnerServiceProvider::boot()` registra las relaciones sobre `Member` sin tocar el archivo:

```php
Member::resolveRelationUsing('partnerNetworks', fn (Member $member) => $member->hasMany(PartnerNetwork::class, 'member_id'));
```

Los helpers de rol (`isPartner()`, comisión resuelta) viven en `Botble\Partner\Supports\PartnerHelper`, no en el modelo.

*Alternativa descartada:* añadir un trait a `Member.php`. Es más legible, pero acopla el plugin `member` al `partner` y rompe en cada actualización de Botble.

### D3 — Asignación por network code con exclusividad en base de datos

Tabla `partner_networks`:

| columna | tipo | notas |
|---|---|---|
| `id` | bigint | |
| `member_id` | bigint | FK lógica a `members`, indexada |
| `network_code` | string(60) | **índice único** |
| `commission` | decimal(12,2) nullable | anula la comisión del partner |
| `status` | string(60) default `published` | |
| timestamps | | |

El índice único sobre `network_code` es lo que garantiza el requisito de exclusividad aunque falle la validación de aplicación. La relación con los dominios es `domains.network_code = partner_networks.network_code` — no hace falta ninguna columna nueva en `domains`.

*Alternativa descartada:* columna `partner_id` en `domains`. Obliga a reasignar dominio a dominio cada vez que la ingesta descubre uno nuevo en una network que ya es del partner.

### D4 — Un servicio de cálculo, numérico de principio a fin

`Botble\Partner\Services\PartnerEarningService`:

```php
public function forPartner(Member $partner, string $period): PartnerMetrics
public function byNetwork(Member $partner, string $period): Collection  // PartnerMetrics por network
```

`PartnerMetrics` es un objeto de valor con `earning`, `impressions`, `clicks`, `ctr`, `ecpm` como `float`. **El formateo ocurre solo en la vista.**

*Por qué:* `PublicController@getDashboard` hoy llama a `getValueWithCommissions()` (que devuelve `"$1,234.56"`) y luego lo revierte con `clearDollarSign()` y `convertToNumber()` — incluido el parseo de sufijos «K/M/B», que pierde precisión. Ese ida y vuelta es una fuente de error real y no lo replicamos.

Cálculo por dominio, con `partner_earning_base`:

```
raw   = (domain.earnings[period] ?? 0) / 1_000_000
base  = base === 'gross'
        ? raw
        : raw × max(0, (commissions ?? percentage_default) − (commissions_network ?? 0)) / 100
aporte = base × comisiónResuelta(network) / 100
```

Impresiones y clicks se suman crudos. CTR y eCPM se recalculan **sobre los totales** (`clicks/impresiones` y `ganancia/impresiones×1000`), no promediando por dominio como hace el panel de creadores — ese promedio es incorrecto cuando los dominios tienen volúmenes dispares.

### D5 — Redirección por rol mediante middleware global, no editando el login

`RedirectPartnerToOwnPanel` se inyecta con `pushMiddlewareToGroup('web', …)` desde `PartnerServiceProvider`. Si hay sesión de miembro con `role = partner` y la ruta actual es del grupo `public.member.*` del panel, redirige a `partner.dashboard`; y a la inversa para el creador que pisa `/partner/*`.

*Por qué:* `LoginController` de `member` termina en `redirect()->intended($this->redirectPath())` → `/account/dashboard`. El middleware global rebota esa redirección al panel correcto **sin tocar el controlador**, y cubre a la vez el acceso directo por URL. Un solo mecanismo resuelve los dos escenarios de la spec.

### D6 — Rutas y vistas

Rutas en `platform/plugins/partner/routes/partner.php`, dentro de `Theme::registerRoutes()`, prefijo `partner`, nombre `partner.`, middleware `['web', 'core', 'member', 'member.kyc.not', 'partner']`:

| ruta | nombre | controlador |
|---|---|---|
| `GET /partner/dashboard` | `partner.dashboard` | `PartnerDashboardController@index` |
| `GET /partner/accounts` | `partner.accounts` | `PartnerDashboardController@accounts` |
| `GET /partner/domains` | `partner.domains` | `PartnerDashboardController@domains` |

Vistas: el controlador intenta `Theme::getThemeNamespace('views.partner.dashboard.<x>')` y **cae a** `plugins/partner::themes.dashboard.<x>` si el tema activo no la define. Así el plugin funciona en `moreno` (el tema activo), `default` o `amauri` sin copiar vistas. El panel de creadores no tiene este fallback; no lo cambiamos, pero el nuestro sí lo lleva.

Las vistas del tema extienden el layout maestro que ya existe (`views.member.dashboard.layouts.master`), de modo que header, sidebar y estilos son los mismos.

### D7 — Menú por rol sin duplicar el registro

`PartnerServiceProvider` registra su propio `DashboardMenu::for('member')->beforeRetrieving(...)` que, cuando el miembro autenticado es partner, hace `removeItem(['cms-member-dashboard', 'cms-member-referrals', 'cms-member-invoices'])` y añade `cms-partner-dashboard`, `cms-partner-accounts`, `cms-partner-domains`. Para un creador no hace nada, así que su menú queda byte a byte igual.

### D8 — Administración

- Menú `Partners` bajo el ítem de miembros, con permisos `partner.index` / `partner.create` / `partner.edit` / `partner.destroy` en `config/permissions.php`.
- `PartnerTable` lista miembros con `role = partner` (comisión, nº de networks, nº de dominios).
- `PartnerForm` promueve/degrada el rol y fija la comisión; `PartnerNetworkForm` asigna network codes elegidos del setting `admanager_networks`, validando en `PartnerNetworkRequest` que el código exista y no esté ya asignado.
- `PartnerSettingForm` añade `partner_percentage_default`, `partner_earning_base` y los toggles `earning_partner`, `clicks_partner`, `impressions_partner`, `ctrs_partner`, `ecpms_partner`.

## Risks / Trade-offs

- **Rendimiento con muchos dominios** → las métricas viven en columnas JSON, así que no se pueden agregar en SQL: hay que traer los dominios de las networks del partner y sumar en PHP. Mitigación: `select` acotado a las columnas necesarias, y cachear el resultado por `(partner, periodo)` con TTL corto si el conteo de dominios supera el umbral. Se documenta el umbral en las tareas.
- **Doble contabilidad si una network se comparte** → el índice único en `partner_networks.network_code` lo impide a nivel de esquema, no solo de validación.
- **`middleware` global sobre el grupo `web`** → se ejecuta en todas las peticiones web. Mitigación: la comprobación sale temprano (`if (! auth('member')->check()) return $next(...)`) antes de tocar la base de datos.
- **Ambigüedad de la base de cálculo** → «el 10% de lo que me da AdSense» admite dos lecturas (sobre el neto de la plataforma o sobre el bruto). Se resuelve con el setting `partner_earning_base` en lugar de fijar una; el default `platform_net` es la lectura literal del enunciado.
- **`percentage_default` como fallback de `commissions`** → si un dominio no tiene `commissions`, la base del partner depende de un setting global que también usan los creadores. Cambiarlo mueve las cifras de ambos. Se deja así por coherencia con el comportamiento actual, y se avisa en el texto de ayuda del setting.
- **Divergencia de fórmulas** → el partner usa CTR/eCPM sobre totales y el creador, promedios. Los dos paneles pueden mostrar cifras distintas para el mismo dominio. Es intencional (la del partner es la correcta), pero hay que documentarlo para soporte.

## Migration Plan

1. Desplegar el plugin desactivado.
2. `php artisan migrate` — la migración es idempotente (`Schema::hasTable` / `hasColumn`). Añade `role` con default `creator` y `commission` nullable a `members`, y crea `partner_networks`. Los miembros existentes quedan como creadores; ningún panel cambia.
3. Activar el plugin desde el admin. Se registran permisos, menú, rutas y settings.
4. Asignar los permisos `partner.*` al rol de administrador correspondiente.
5. Configurar `partner_percentage_default` y `partner_earning_base`.
6. Promover el primer partner y asignarle sus network codes; verificar contra un reporte conocido de Ad Manager.

**Rollback:** desactivar el plugin. Las rutas, el menú y el middleware desaparecen; `members.role` queda en `creator` para todos los efectos prácticos y el panel de creadores nunca se vio afectado. La migración `down()` elimina `partner_networks` y las dos columnas.

## Open Questions

1. ¿La ganancia del partner debe descontarse en algún sitio de la ganancia de la plataforma (`commissions_platform` en el panel de creadores), o es un coste que se lleva aparte? Este change asume **aparte**: no se toca ninguna cifra del panel de creadores.
2. ~~¿Hace falta un modo «global»?~~ **Resuelto (confirmado por el usuario)**: «el partner verá todos los ingresos de ese admanager que se le asoció». El alcance es la network asignada, entera: todos sus dominios, con independencia de qué creador los tenga o de si tienen creador. No se filtra por `member_id` ni por `status`. Si un partner debe ver más, se le asignan más networks. Verificado contra la base real: un partner asociado a `23089538066` ve los 4 dominios de esa network, pertenecientes a dos creadores distintos.
3. ¿Debe un partner poder ser además creador de sus propios dominios? Este change asume que **no**: el rol es exclusivo. Si se necesitara, el modelo de columna `role` habría que cambiarlo por un conjunto de roles.
