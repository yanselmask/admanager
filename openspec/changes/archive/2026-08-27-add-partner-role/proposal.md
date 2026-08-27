## Why

Hoy la plataforma solo contempla un tipo de miembro: el **creador**, dueño de un dominio, que ve en `/account/dashboard` las métricas de *su* dominio con su comisión aplicada. No existe forma de dar acceso a un **partner** comercial: la persona que aporta cuentas completas de AdSense/Ad Manager (networks enteras, con todos sus dominios) y cobra un porcentaje sobre lo que la plataforma recibe de esas cuentas.

Sin este rol, los partners dependen de reportes manuales para saber cuánto han generado, no tienen visibilidad de qué dominios cuelgan de las cuentas que trajeron, y la plataforma no tiene registro estructurado de qué network pertenece a qué partner.

## What Changes

- **Nuevo plugin `partner`** (`platform/plugins/partner/`) que encapsula rol, asignación de networks, cálculo de ganancias y panel.
- **Rol en `members`**: nueva columna `role` (`creator` | `partner`, default `creator`). Los miembros existentes quedan como `creator` — sin cambio de comportamiento.
- **Asignación de networks**: nueva tabla pivote `partner_networks` (`member_id`, `network_code`, `commission` opcional). Un partner puede tener N network codes; un network code puede pertenecer a un solo partner.
- **Comisión del partner**: columna `commission` en `members` (nullable) + setting global `partner_percentage_default`. Precedencia: comisión de la network asignada → comisión del partner → setting global.
- **Base de cálculo configurable**: setting `partner_earning_base` con dos modos — `platform_net` (default: lo que la plataforma efectivamente recibe, `commissions − commissions_network`) y `gross` (revenue bruto del reporte).
- **Panel del partner** en `/partner/*`: los ingresos **completos** de cada network que se le asoció — todos sus dominios, tengan el creador que tengan o ninguno — agregados y con desglose por network, listado de dominios y filtro por periodo — reutilizando el layout, la sesión y el guard `member` que ya usa el panel de creadores.
- **Separación de paneles**: middleware `partner` y `member.creator` que redirigen a cada rol a su panel; el menú lateral (`DashboardMenu::for('member')`) se filtra por rol.
- **Administración**: sección en el admin para marcar un miembro como partner, fijar su comisión y asignarle network codes (elegidos del repeater `admanager_networks` ya existente).
- **NO BREAKING**: el panel de creadores, sus rutas, vistas y cálculos quedan intactos.

## Capabilities

### New Capabilities
- `partner-role`: identidad del partner — rol sobre el guard `member`, comisión propia, restricción de acceso y separación entre el panel de creador y el de partner.
- `partner-network-assignment`: asignación y administración de network codes de Ad Manager a un partner desde el panel de administración, incluida la exclusividad de cada network.
- `partner-earnings`: cálculo de las métricas del partner (ganancias, impresiones, clicks, CTR, eCPM) agregando los dominios de sus networks y aplicando su porcentaje sobre la base configurada.
- `partner-dashboard`: panel público del partner — rutas, vistas, tarjetas de métricas, desglose por network, listado de dominios y filtro por periodo.

### Modified Capabilities
_(ninguna: no existen specs previas en `openspec/specs/`; el panel de creadores no cambia de comportamiento)_

## No incluido

- **Facturación / pagos al partner**: el plugin muestra métricas, no genera facturas ni órdenes de pago. Reutilizar el módulo `invoice` de `member` queda para un change posterior.
- **Registro público de partners**: un partner se crea promoviendo a un miembro existente desde el admin. No hay formulario de alta en el front.
- **Cambios en la ingesta de Google Ad Manager**: el servicio `Botble\Admanager\Services\Admanager` no se toca. El partner lee los mismos datos que ya se vuelcan en `domains`.
- **Sub-partners / referidos de partner**: fuera de alcance.
- **KYC específico de partner**: se reutiliza el flujo de KYC de `member` tal cual está.
- **API pública para partners**: solo panel web.

## Impact

**Código nuevo**
- `platform/plugins/partner/` completo (plugin.json, Plugin.php, ServiceProvider, modelos, tabla, formularios, controladores, rutas, permisos, migraciones, traducciones).
- `platform/themes/default/views/partner/dashboard/` (vistas del panel).

**Código modificado**
- `platform/plugins/member/src/Models/Member.php` — `role` y `commission` en `$fillable`, relaciones `partnerNetworks()` / `partnerDomains()`, scopes `partners()` / `creators()`. *(Alternativa evaluada en design.md: extender vía el propio plugin sin tocar `member`.)*
- `platform/plugins/member/src/Providers/MemberServiceProvider.php` — filtrado del menú del panel por rol.
- Redirección post-login: `LoginController` / `RedirectIfMember` deben enviar al partner a `/partner/dashboard`.

**Base de datos**
- `members`: + `role` (string, default `creator`, indexada), + `commission` (decimal 12,2 nullable).
- Nueva tabla `partner_networks`.

**Settings nuevos**
- `partner_percentage_default`, `partner_earning_base`, y los toggles de visibilidad de métricas del panel de partner (`earning_partner`, `clicks_partner`, …), en línea con los `*_member` ya existentes.

**Dependencias**: ninguna nueva. Requiere `member`, `domain` y `admanager` activos.
