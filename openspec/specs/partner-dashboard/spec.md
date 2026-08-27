# partner-dashboard Specification

## Purpose
TBD - created by archiving change add-partner-role. Update Purpose after archive.
## Requirements
### Requirement: Panel de estadísticas del partner
El sistema DEBE (SHALL) ofrecer a un miembro con rol `partner` un panel en `/partner/dashboard` con tarjetas de métricas agregadas: ganancia, impresiones, clicks, CTR y eCPM del periodo seleccionado.

#### Scenario: Carga del panel
- **WHEN** un partner autenticado abre `/partner/dashboard`
- **THEN** ve las tarjetas de métricas calculadas sobre los dominios de sus networks asignadas

#### Scenario: Partner recién creado
- **WHEN** un partner sin networks asignadas abre su panel
- **THEN** el panel carga con todas las métricas en cero y un aviso de que aún no tiene cuentas asignadas

#### Scenario: Reutilización del layout
- **WHEN** un partner navega por cualquier vista de su panel
- **THEN** la página usa el mismo layout maestro y estilos del panel de miembros existente

### Requirement: Filtro por periodo
El panel DEBE (SHALL) permitir cambiar el periodo de las métricas mediante el parámetro de consulta `period`, ofreciendo las mismas opciones que ya expone el panel de creadores.

#### Scenario: Cambio de periodo
- **WHEN** un partner selecciona «Este mes» en el selector de periodo
- **THEN** la página recarga con `?period=this_month`
- **AND** todas las tarjetas y el desglose reflejan ese periodo

#### Scenario: Periodo conservado al navegar
- **WHEN** un partner con `?period=this_month` activo entra al listado de dominios
- **THEN** el listado muestra las métricas de `this_month`

### Requirement: Vista de cuentas del partner
El panel DEBE (SHALL) incluir una vista `/partner/accounts` con una fila por network asignada, mostrando nombre de la network, network code, comisión aplicada, número de dominios y las métricas de esa network en el periodo seleccionado.

#### Scenario: Listado de cuentas
- **WHEN** un partner con dos networks abre `/partner/accounts`
- **THEN** ve dos filas, cada una con su nombre, código, comisión, conteo de dominios y métricas

#### Scenario: Coherencia con el total
- **WHEN** el partner compara la suma de las ganancias del listado de cuentas con la tarjeta de ganancia total del dashboard en el mismo periodo
- **THEN** ambos valores coinciden

### Requirement: Vista de dominios del partner
El panel DEBE (SHALL) incluir una vista `/partner/domains` con los dominios de las networks asignadas, mostrando URL, network a la que pertenece, estado y sus métricas del periodo, con paginación.

#### Scenario: Listado de dominios
- **WHEN** un partner abre `/partner/domains`
- **THEN** ve los dominios de todas sus networks con URL, network, estado y métricas del periodo

#### Scenario: Filtrado por network
- **WHEN** un partner abre `/partner/domains?network=123456`
- **THEN** solo ve los dominios de esa network

#### Scenario: Filtrado por una network ajena
- **WHEN** un partner solicita `/partner/domains?network=555555`, código que no tiene asignado
- **THEN** el sistema no devuelve ningún dominio de esa network

#### Scenario: Paginación
- **WHEN** las networks del partner contienen más dominios de los que caben en una página
- **THEN** el listado se pagina y conserva los filtros de periodo y network entre páginas

### Requirement: Visibilidad configurable de las métricas
El sistema DEBE (SHALL) permitir al administrador activar o desactivar individualmente cada métrica del panel de partner mediante settings (`earning_partner`, `clicks_partner`, `impressions_partner`, `ctrs_partner`, `ecpms_partner`), de forma análoga a los settings `*_member` existentes.

#### Scenario: Métrica desactivada
- **WHEN** el setting `ecpms_partner` está desactivado
- **THEN** la tarjeta de eCPM y su serie en el gráfico no se muestran en el panel del partner

#### Scenario: Todas las métricas activas
- **WHEN** todos los settings `*_partner` están activos
- **THEN** el panel muestra las cinco tarjetas

### Requirement: Gráfico de evolución
El panel DEBE (SHALL) mostrar un gráfico con las métricas activadas del partner a lo largo de los periodos disponibles, siguiendo el mismo componente que usa el panel de creadores.

#### Scenario: Gráfico con métricas activas
- **WHEN** un partner abre su panel con las métricas de ganancia y clicks activadas
- **THEN** el gráfico dibuja ambas series
- **AND** los valores de la serie de ganancia son los ya ajustados por su comisión

### Requirement: Aislamiento de la información del partner
El panel del partner NO DEBE (SHALL NOT) exponer datos que le sean ajenos: ni las ganancias brutas de la plataforma, ni las comisiones de los creadores, ni datos de otros partners.

#### Scenario: Sin cifras brutas
- **WHEN** un partner consulta cualquier vista de su panel
- **THEN** todos los importes mostrados están ya ajustados por su comisión
- **AND** no aparece el revenue bruto del reporte de Ad Manager ni la comisión de la plataforma

#### Scenario: Sin datos de creadores
- **WHEN** un partner abre el listado de dominios
- **THEN** no se muestran los datos personales ni la comisión del creador asignado a cada dominio

#### Scenario: Acceso directo a una ruta de otro rol
- **WHEN** un partner solicita una ruta del panel de creadores mediante URL directa
- **THEN** el sistema lo redirige a su propio panel sin revelar información

