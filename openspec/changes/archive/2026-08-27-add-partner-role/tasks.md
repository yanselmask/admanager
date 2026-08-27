## 1. Andamiaje del plugin

- [x] 1.1 Crear `platform/plugins/partner/plugin.json` (id `yanselmask/partner`, namespace `Botble\Partner\`, provider `Botble\Partner\Providers\PartnerServiceProvider`) siguiendo el formato de `platform/plugins/domain/plugin.json`.
- [x] 1.2 Crear `platform/plugins/partner/src/Plugin.php` con `remove()`, que elimina `partner_networks`, las columnas `role`/`commission` de `members` y los settings del plugin.
- [x] 1.3 Crear `platform/plugins/partner/src/Providers/PartnerServiceProvider.php` con `setNamespace('plugins/partner')`, `loadHelpers()`, `loadAndPublishConfigurations(['permissions'])`, `loadAndPublishTranslations()`, `loadAndPublishViews()`, `loadRoutes(['web', 'partner'])` y `loadMigrations()`.
- [x] 1.4 ~~Registrar el namespace en `composer.json`~~ — **no aplica**. Botble autocarga los namespaces de plugins en runtime desde el campo `namespace` de `plugin.json` (`platform/packages/plugin-management/src/Providers/PluginManagementServiceProvider.php:31`, `$loader->setPsr4(...)`), y solo para plugins activos. En su lugar: activar con `php artisan cms:plugin:activate partner` y verificar que `Botble\Partner\Plugin` resuelve.
- [x] 1.5 Crear `platform/plugins/partner/config/permissions.php` con los flags `partner.index`, `partner.create`, `partner.edit`, `partner.destroy` y `partner.settings` (mismo formato que `platform/plugins/domain/config/permissions.php`).
- [x] 1.6 Crear `platform/plugins/partner/resources/lang/en/partner.php` con los textos del plugin.
- [x] 1.7 Crear los stubs `platform/plugins/partner/routes/web.php` y `routes/partner.php` — obligatorios porque `loadRoutes()` hace `require` del archivo sin comprobar que exista, y el provider fallaría al arrancar. Se rellenan en 5.8 y 8.1.
- [x] 1.8 Crear `platform/plugins/partner/helpers/helpers.php` con `is_partner()` y `current_partner()`, sin dependencias de clases de grupos posteriores.
- [x] 1.9 Verificar el arranque: `cms:plugin:list` muestra el plugin activo, las traducciones y los permisos cargan, y `route:list --name=public.member` sigue devolviendo las 39 rutas del panel de creadores.

## 2. Base de datos

- [x] 2.1 Crear `platform/plugins/partner/database/migrations/2026_08_27_000000_partner_create_partner_networks_table.php` con la tabla `partner_networks` (`member_id` indexada, `network_code` con **índice único**, `commission` decimal(12,2) nullable, `status`, timestamps), envuelta en `Schema::hasTable`.
- [x] 2.2 En la misma migración, añadir a `members` las columnas `role` (string 20, default `creator`, indexada) y `commission` (decimal 12,2 nullable), protegidas con `Schema::hasColumn`.
- [x] 2.3 Implementar `down()` eliminando `partner_networks` y las dos columnas de `members`.
- [x] 2.4 Ejecutar `php artisan migrate` y verificar que los miembros existentes quedan con `role = creator` y que `/account/dashboard` sigue funcionando igual. Verificado en MySQL: `UNIQUE KEY partner_networks_network_code_unique`, `KEY partner_networks_member_id_index`, `members.role varchar(20) NOT NULL DEFAULT 'creator'` indexada, los 12 miembros en `creator`, y `PublicController@getDashboard` devuelve la vista con cifras correctas.
- [x] 2.5 **Nota de despliegue**: `php artisan migrate` arrastró 4 migraciones de `vendor/botble/api` que llevaban pendientes desde antes de este change (`device_tokens`, `push_notifications`, `push_notification_recipients`, `user_settings`), y quedaron en el mismo batch 12 que la nuestra. En producción hay que ejecutarlas por separado o asumirlas; `migrate:rollback` sin `--step` revertiría las cinco a la vez.
- [x] 2.6 **Corrección**: el tema activo es `moreno` (`setting('theme') = 'moreno'`), no `default`. Ajustadas las rutas de vistas en `design.md` (D6) y en la tarea 8.7.

## 3. Modelos y helpers de rol

- [x] 3.1 Crear `platform/plugins/partner/src/Enums/PartnerRoleEnum.php` con los valores `creator` y `partner`, y añadir sus etiquetas en `resources/lang/en/partner.php` (`partner.roles`).
- [x] 3.2 Crear `platform/plugins/partner/src/Models/PartnerNetwork.php` (tabla `partner_networks`, `$fillable`, cast de `status` a `BaseStatusEnum`, relaciones `member()` y `domains()` sobre `domains.network_code`, y accesor `network_name` que resuelve el nombre desde `admanager_networks`).
- [x] 3.3 Crear `platform/plugins/partner/src/Supports/PartnerHelper.php` con `isPartner()`, `isCreator()` y `resolveCommission()` implementando la precedencia network → partner → `partner_percentage_default` → 0, acotando el resultado a [0, 100].
- [x] 3.4 En `PartnerServiceProvider::boot()`, inyectar `partnerNetworks` (`hasMany`) y `partnerDomains` (`hasManyThrough` sobre `network_code`) con `Member::resolveRelationUsing()` — **sin editar** `platform/plugins/member/src/Models/Member.php`. SQL verificado: `select * from domains inner join partner_networks on partner_networks.network_code = domains.network_code where partner_networks.member_id = ?`.
- [x] 3.5 Escribir `tests/Feature/Partner/PartnerCommissionTest.php` — 9 tests en verde: rol por defecto, promoción, los cuatro niveles de precedencia de comisión, resolución sin network, acotado de valores fuera de rango y alcance de `partnerDomains`. El **rechazo por validación** de comisiones fuera de 0–100 se prueba en 5.10, donde existe `PartnerRequest`; aquí se cubre el acotado defensivo del helper.
- [x] 3.6 Registrar `registerMemberDefaults()` en `PartnerServiceProvider`: el default `creator` lo aplica la base de datos, así que un `Member` recién creado tenía `role = null` en memoria hasta recargarlo. Se fija en el evento `creating`. (`isPartner()` ya trataba null como no-partner, así que no había riesgo de escalada, pero el invariante de la spec no se cumplía sin releer.)

## 3bis. Infraestructura de tests (no prevista en el plan original)

- [x] 3b.1 Diagnosticar por qué la suite no arrancaba: `phpunit.xml` usaba sqlite `:memory:` sin ejecutar migraciones, así que **no existía ninguna tabla**. `tests/Feature/ExampleTest.php` llevaba fallando con 500 desde antes de este change.
- [x] 3b.2 Identificar la causa de fondo: las migraciones de plugin solo se cargan para plugins activos, y `get_active_plugins()` lee `Setting::get('activated_plugins')` de la BD **al arrancar** (`platform/packages/plugin-management/helpers/common.php:24`). Sobre una base vacía no hay plugins activos, luego sus migraciones nunca corren.
- [x] 3b.3 Crear `tests/prepare-database.sh`: arranque en dos fases (migrar core → sembrar `activated_plugins` → migrar de nuevo en un proceso nuevo) que genera `database/testing.sqlite` con el esquema completo.
- [x] 3b.4 Apuntar `phpunit.xml` a `database/testing.sqlite` en lugar de `:memory:`, con el porqué comentado, y añadir el archivo a `.gitignore`.
- [x] 3b.5 Usar `DatabaseTransactions` en los tests (no `RefreshDatabase`: un `migrate:fresh` en proceso borraría la fila `activated_plugins` y dejaría la base sin plugins en el siguiente arranque).
- [x] 3b.6 Verificar la suite completa: `php artisan test --compact` → 11 tests en verde, incluido el `ExampleTest` que estaba roto.

## 4. Servicio de cálculo de métricas

- [x] 4.1 Crear `platform/plugins/partner/src/Data/PartnerMetrics.php` como objeto de valor readonly con `earning`, `impressions`, `clicks`, `ctr` y `ecpm` en `float`, más `zero()`, `fromTotals()` y `toArray()`.
- [x] 4.2 Crear `platform/plugins/partner/src/Services/PartnerEarningService.php` con `forPartner()`, `byNetwork()`, `domainsOf()`, `networksOf()` y `resolvePeriod()`.
- [x] 4.3 Implementar el cálculo por dominio de D4: micros entre 1.000.000, base según `partner_earning_base` (`platform_net` | `gross`), `commissions` nulo → `percentage_default`, `commissions_network` nulo → 0, y base truncada a 0 con `max(0.0, ...)` cuando sería negativa.
- [x] 4.4 Implementar la agregación en `PartnerMetrics::fromTotals()`: impresiones y clicks crudos; CTR y eCPM derivados de los totales, devolviendo 0 cuando las impresiones son 0.
- [x] 4.5 Implementar `resolvePeriod()` con la lista `PERIODS` (espejo de las opciones de `AdmanagerSettingForm`) y `today` como default y como fallback.
- [x] 4.6 Consultar los dominios con `whereIn('network_code', $codes)` limitando a `DOMAIN_COLUMNS`. Medido: **2 queries constantes** (networks + dominios) sea cual sea el número de dominios, sin N+1.
- [x] 4.7 Escribir `tests/Feature/Partner/PartnerEarningServiceTest.php` — 18 tests en verde cubriendo ambas bases, fallback a `percentage_default`, base negativa truncada, comisiones por network distintas, periodo ausente/explícito/desconocido, suma cruda de impresiones y clicks, CTR y eCPM sobre totales, división por cero, dominios ajenos excluidos, dominio sin creador incluido, aislamiento entre partners, partner sin networks, coincidencia desglose↔total y network sin dominios.
- [x] 4.8 Verificar el cálculo contra la base real: con `percentage_default = 12` y partner al 10%, los 4 dominios de la network `23089538066` dan `earning = 13.841514` para `today`, que coincide dígito a dígito con el cálculo a mano (0.0005888 + 0.0000159 + 9.5454545 + 4.2954545).

## 5. Administración

- [x] 5.1 Crear `platform/plugins/partner/src/Tables/PartnerTable.php` listando miembros con `role = partner` (nombre, email, comisión con indicación de herencia, nº de networks vía `withCount`, fecha).
- [x] 5.2 Crear `platform/plugins/partner/src/Forms/PartnerForm.php`. Al crear ofrece solo miembros que aún no son partner; al editar, fija el miembro. `role` y `commission` se asignan por propiedad en el controlador, no por `fill()`.
- [x] 5.3 Crear `platform/plugins/partner/src/Http/Requests/PartnerRequest.php` validando `member_id`, `role` dentro de `PartnerRoleEnum::values()` y `commission` `between:0,100`.
- [x] 5.4 Crear `platform/plugins/partner/src/Tables/PartnerNetworkTable.php` con partner, nombre de network, código, comisión resuelta y nº de dominios (`withCount('domains')`, no una query por fila).
- [x] 5.5 Crear `platform/plugins/partner/src/Forms/PartnerNetworkForm.php` con el selector de networks y el de partners (solo miembros con `role = partner`).
- [x] 5.6 Crear `platform/plugins/partner/src/Http/Requests/PartnerNetworkRequest.php` con reglas de clausura: el network code debe existir en `admanager_networks`, el miembro debe ser partner, y el código no puede estar asignado a otro partner — el mensaje nombra al partner que lo tiene, ignorando el propio registro al editar.
- [x] 5.7 Crear `PartnerController.php` y `PartnerNetworkController.php`. **`PartnerController@destroy` degrada a creador, no borra al miembro**, y conserva sus asignaciones, como exige `partner-role/spec.md`.
- [x] 5.8 Crear `platform/plugins/partner/routes/web.php` con los dos recursos dentro de `AdminHelper::registerRoutes()`. Verificado: 12 rutas registradas bajo `admin/partners` y `admin/partner-networks`.
- [x] 5.9 Registrar el menú `cms-plugins-partner` y el submenú `cms-plugins-partner-networks` en `PartnerServiceProvider`, con permiso `partner.index`.
- [x] 5.10 Escribir `tests/Feature/Partner/PartnerNetworkAssignmentTest.php` — 13 tests en verde: asignación simple y múltiple, network no configurada, miembro que no es partner, exclusividad con el nombre del partner en el mensaje, reasignación tras liberar, rechazo del índice único a nivel de base de datos, edición sin colisión consigo misma, retirada sin tocar las métricas del dominio, comisión fuera y dentro de rango, rol desconocido y degradación conservando asignaciones.
- [x] 5.11 Crear `platform/plugins/partner/src/Supports/AdmanagerNetworks.php` para centralizar la lectura del repeater `admanager_networks`, hoy duplicada en `DomainForm` y `DomainRequest`.

> **Nota sobre el 403 sin permiso**: la comprobación de permisos la aplica el middleware de Botble sobre las rutas del admin, no el controlador. Se verifica en el repaso funcional de 10.5, junto con el resto del flujo autenticado.

## 6. Settings

- [x] 6.1 Crear `platform/plugins/partner/src/Forms/PartnerSettingForm.php` con `partner_percentage_default`, `partner_earning_base` (select `platform_net` | `gross`) y los cinco toggles de visibilidad, generados desde la constante `METRICS`. **Desviación**: los `*_member` equivalentes son `MultiCheckListField` de periodos que el controlador solo evalúa por truthiness — un patrón confuso. Los `*_partner` son `OnOffField`, que es lo que describen los escenarios de la spec. Por defecto vienen **activados**.
- [x] 6.2 Crear `platform/plugins/partner/src/Http/Controllers/PartnerSettingController.php` (sobre `SettingController`) y `PartnerSettingRequest` validando el porcentaje `between:0,100` y la base dentro de los dos valores admitidos.
- [x] 6.3 Registrar el panel de settings con `PanelSectionManager` en `PartnerServiceProvider` y las rutas `admin/settings/partners` (GET y PUT con permiso `partner.settings`).
- [x] 6.4 Añadir al texto de ayuda de `partner_earning_base` la advertencia de que `percentage_default` se usa como fallback de `commissions` y afecta también a los creadores.
- [x] 6.5 **Hallazgo**: el tema activo `moreno` no consume `optionsGraf`, `optionsAlt` ni los settings `*_member`, así que la visibilidad configurable de métricas está muerta en el panel de creadores. Las vistas del partner (grupo 8) sí deben respetar los `*_partner`.

## 7. Acceso y separación de paneles

- [x] 7.1 Crear `platform/plugins/partner/src/Http/Middleware/RedirectIfNotPartner.php` (alias `partner`): manda al visitante sin sesión al login y al creador autenticado a `public.member.dashboard`.
- [x] 7.2 Crear `platform/plugins/partner/src/Http/Middleware/RedirectPartnerToOwnPanel.php`, acotado a las tres rutas del panel de creadores (`dashboard`, `referrals`, `invoices`) para no interferir con ajustes, KYC ni logout. **Medido: 0,009 ms por petición y 0 queries** cuando no hay sesión de miembro, gracias a la salida temprana.
- [x] 7.3 En `PartnerServiceProvider::boot()`, registrar el alias `partner` y hacer `pushMiddlewareToGroup('web', RedirectPartnerToOwnPanel::class)` — **sin editar** el plugin `member`.
- [x] 7.4 Escribir `tests/Feature/Partner/PartnerAccessTest.php` — 9 tests en verde: partner→panel propio, creador→panel propio, visitante→login en las tres rutas, partner alcanza sus tres rutas, redirección tras login, rutas de miembro no afectadas, creador conserva su dashboard, y el filtro `?network=` de una network ajena no devuelve nada.
- [x] 7.5 Adelantar el registro de rutas del panel (tarea 8.1) porque `RedirectPartnerToOwnPanel` necesita que `partner.dashboard` resuelva. `PartnerDashboardController` ya calcula métricas reales vía el servicio; **devuelve JSON de forma provisional** hasta que el grupo 8 le monte las vistas.

## 8. Panel del partner

- [x] 8.1 Crear `platform/plugins/partner/routes/partner.php` con `partner.dashboard`, `partner.accounts` y `partner.domains` dentro de `Theme::registerRoutes()`, middleware `['web','core','member','member.kyc.not','partner']`. (Adelantado en 7.5.)
- [x] 8.2 Crear `PartnerDashboardController` con `index()`, `accounts()` y `domains()`, resolviendo la vista del tema con `view()->exists()` y cayendo a `plugins/partner::themes.dashboard.<x>`.
- [x] 8.3 Implementar en `index()` la lectura de `?period`, `forPartner()` y `visibleMetrics()` a partir de los settings `*_partner`.
- [x] 8.4 Implementar `accounts()` con `byNetwork()`, incluyendo las networks sin dominios en cero.
- [x] 8.5 Implementar `domains()` con `domainsQuery()->paginate(20)->appends(...)`. **Bug encontrado y corregido**: `keyBy('network_code')` deja claves `int` porque PHP convierte las claves numéricas, así que `in_array('123456', [123456], true)` era siempre `false` y el filtro por cuenta no devolvía nada. Se comparan como cadenas.
- [x] 8.6 Crear las vistas de fallback autocontenidas en `platform/plugins/partner/resources/views/themes/dashboard/` (`_layout`, `_cards`, `index`, `accounts`, `domains`), sin dependencias del tema.
- [x] 8.7 Crear `platform/themes/moreno/views/partner/dashboard/` (`_shell`, `_cards`, `index`, `accounts`, `domains`) extendiendo el layout maestro del panel de miembros. **Nota**: `@php(...)` antes de `@extends` no compila en Blade; se usa el namespace literal `theme.moreno::`, igual que el resto de vistas del tema.
- [x] 8.8 Añadir el aviso «aún no tienes cuentas asignadas» en las tres vistas, manteniendo las métricas en cero.
- [x] 8.9 **Corrección del plan**: el panel de creadores de `moreno` no tiene ningún gráfico que reutilizar — calcula `optionsGraf`/`optionsAlt` y no los usa. Sí carga `echarts.min.js` en el footer, así que el gráfico del partner se construye con echarts (sin dependencias nuevas), alimentado por `PartnerEarningService::seriesFor()`, que carga los dominios **una sola vez** para los 11 periodos en lugar de una consulta por periodo.
- [x] 8.10 Escribir `tests/Feature/Partner/PartnerDashboardTest.php` — 15 tests: métricas, partner sin cuentas, filtro de periodo, listado de cuentas, coherencia desglose↔total, cuenta sin dominios, listado y filtrado de dominios, paginación conservando filtros, métrica desactivada, **sin cifras brutas ni de plataforma**, **sin datos del creador**, menú por rol y uso del fallback de vistas.

## 9. Menú del panel

- [x] 9.1 Registrar `registerPartnerPanelMenu()` en `PartnerServiceProvider`: si el miembro autenticado no es partner, la clausura sale sin tocar nada.
- [x] 9.2 Aserciones en `PartnerDashboardTest`: el partner ve las tres entradas propias y ninguna de creador; el creador conserva `cms-member-dashboard`, `cms-member-referrals` y `cms-member-invoices`, y no ve ninguna `cms-partner-*`.

## 10. Cierre

- [x] 10.1 Medir el tiempo de `PartnerEarningService::forPartner()` con un partner de ~500 dominios. **Medido: 107,6 ms y 2 queries** con 500 dominios sintéticos (`earning = 2250.00`, exactamente 500 × 4,50). Por debajo del umbral de 300 ms, así que **no se añade caché**. Revisar si un partner llega a superar ~1.500 dominios.
- [x] 10.2 `vendor/bin/pint --dirty --format agent` → pass.
- [x] 10.3 `php artisan test --compact --filter=Partner` → **64 tests, 157 aserciones, en verde**.
- [x] 10.4 `php artisan test --compact` → **66 tests en verde**, incluido el `ExampleTest` que estaba roto antes de este change.
- [x] 10.5 Flujo de extremo a extremo sobre la base real: promovido «Moreno Demo» al 10%, asignadas dos cuentas (una hereda el 10%, otra con 20% propio). Desglose `129.342642 + 18.000000 = 147.342642`, **idéntico al total** del panel. La segunda cuenta se comprobó a mano: `200 × 45% × 20% = 18.000000`. Las tres vistas renderizan y el menú muestra las entradas de partner.
