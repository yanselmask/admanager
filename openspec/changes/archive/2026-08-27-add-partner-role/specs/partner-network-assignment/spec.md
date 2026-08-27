## ADDED Requirements

### Requirement: Asignación de networks a un partner
El sistema DEBE (SHALL) permitir asignar uno o varios network codes de Google Ad Manager a un miembro con rol `partner`. Los network codes disponibles se toman del setting `admanager_networks` ya configurado en el plugin `admanager`.

#### Scenario: Asignar una network
- **WHEN** un administrador con permiso `partner.edit` asigna el network code `123456` a un partner
- **THEN** se crea un registro en `partner_networks` con ese `member_id` y `network_code`
- **AND** el partner ve inmediatamente los dominios cuyo `network_code` es `123456`

#### Scenario: Asignar varias networks
- **WHEN** un administrador asigna los network codes `123456` y `789012` al mismo partner
- **THEN** el panel del partner agrega los dominios de ambas networks

#### Scenario: Network code no configurado en Ad Manager
- **WHEN** un administrador intenta asignar un network code que no existe en el setting `admanager_networks`
- **THEN** la validación falla y no se crea la asignación

#### Scenario: Asignar a un miembro que no es partner
- **WHEN** un administrador intenta asignar una network a un miembro con `role = creator`
- **THEN** la validación falla indicando que el miembro debe tener rol partner

### Requirement: Exclusividad de la network
Un network code DEBE (SHALL) pertenecer como máximo a un partner. El sistema NO DEBE (SHALL NOT) permitir que dos partners compartan la misma network, para que las ganancias no se contabilicen dos veces.

#### Scenario: Network ya asignada a otro partner
- **WHEN** un administrador intenta asignar el network code `123456` a un partner B
- **AND** ese network code ya está asignado al partner A
- **THEN** la operación falla con un mensaje que identifica al partner A

#### Scenario: Reasignación explícita
- **WHEN** un administrador retira el network code `123456` del partner A
- **AND** después lo asigna al partner B
- **THEN** la asignación se completa
- **AND** el partner A deja de ver los dominios de esa network

#### Scenario: Restricción a nivel de base de datos
- **WHEN** se intenta insertar un segundo registro con el mismo `network_code` en `partner_networks`
- **THEN** el índice único de la columna rechaza la inserción

### Requirement: Retirada de una network
Un administrador DEBE (SHALL) poder retirar una network asignada a un partner. La retirada NO DEBE (SHALL NOT) modificar los datos de los dominios ni el historial de métricas.

#### Scenario: Retirar una network
- **WHEN** un administrador retira el network code `123456` de un partner
- **THEN** el registro de `partner_networks` se elimina
- **AND** los dominios con ese `network_code` conservan intactos sus `earnings`, `clicks`, `impressions`, `ctrs` y `ecpms`
- **AND** el partner deja de ver esos dominios y sus métricas

#### Scenario: Partner sin networks
- **WHEN** un partner no tiene ninguna network asignada
- **THEN** su panel carga correctamente mostrando todas las métricas en cero y un aviso de que aún no tiene cuentas asignadas

### Requirement: Listado administrativo de asignaciones
El panel de administración DEBE (SHALL) ofrecer un listado de asignaciones partner–network con el partner, el nombre y el código de la network, la comisión aplicable y el número de dominios que cuelgan de ella.

#### Scenario: Consultar el listado
- **WHEN** un administrador con permiso `partner.index` abre el listado de asignaciones
- **THEN** ve una fila por asignación con partner, nombre de network, network code, comisión resuelta y conteo de dominios

#### Scenario: Acceso sin permiso
- **WHEN** un usuario administrador sin permiso `partner.index` abre la ruta del listado
- **THEN** el sistema responde 403
