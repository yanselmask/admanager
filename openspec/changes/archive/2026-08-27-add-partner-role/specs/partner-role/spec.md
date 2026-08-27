## ADDED Requirements

### Requirement: Rol del miembro
Cada miembro DEBE (SHALL) tener un rol, con valor `creator` o `partner`. El rol por defecto es `creator`, de modo que todos los miembros existentes conservan su comportamiento actual sin intervención.

#### Scenario: Miembro nuevo sin rol explícito
- **WHEN** se crea un miembro sin especificar `role`
- **THEN** el sistema le asigna `creator`

#### Scenario: Miembros existentes tras la migración
- **WHEN** se ejecuta la migración del plugin `partner` sobre una base con miembros ya creados
- **THEN** todos esos miembros quedan con `role = creator`
- **AND** su panel, rutas y métricas siguen funcionando igual que antes

#### Scenario: Rol inválido
- **WHEN** se intenta guardar un miembro con un `role` distinto de `creator` o `partner`
- **THEN** la validación falla y el miembro no se guarda

### Requirement: Promoción de un miembro a partner
Un administrador con permiso `partner.edit` DEBE (SHALL) poder cambiar el rol de un miembro a `partner` desde el panel de administración. La promoción NO DEBE (SHALL NOT) borrar ni alterar los dominios que ese miembro tuviera asignados como creador.

#### Scenario: Promoción exitosa
- **WHEN** un administrador con permiso `partner.edit` marca a un miembro como `partner` y guarda
- **THEN** el miembro queda con `role = partner`
- **AND** en su siguiente inicio de sesión es dirigido al panel de partner

#### Scenario: Promoción sin permiso
- **WHEN** un usuario administrador sin el permiso `partner.edit` intenta cambiar el rol de un miembro
- **THEN** el sistema responde 403 y el rol no cambia

#### Scenario: Degradación a creador
- **WHEN** un administrador cambia el rol de un partner de vuelta a `creator`
- **THEN** sus asignaciones de network se conservan pero dejan de producir efecto
- **AND** el acceso a `/partner/*` queda denegado

### Requirement: Comisión del partner
Un partner DEBE (SHALL) tener un porcentaje de comisión resoluble. El sistema resuelve el porcentaje aplicable con esta precedencia, tomando el primer valor no nulo: comisión de la asignación de network → comisión del miembro partner → setting global `partner_percentage_default`.

#### Scenario: Comisión definida en la asignación de network
- **WHEN** la asignación `partner_networks` de una network tiene `commission = 15`
- **AND** el partner tiene `commission = 10`
- **THEN** para esa network el sistema usa 15

#### Scenario: Comisión definida solo en el partner
- **WHEN** la asignación de network no tiene comisión
- **AND** el partner tiene `commission = 12`
- **THEN** el sistema usa 12

#### Scenario: Sin comisión propia
- **WHEN** ni la asignación ni el partner tienen comisión
- **AND** `partner_percentage_default` vale 10
- **THEN** el sistema usa 10

#### Scenario: Sin comisión en ningún nivel
- **WHEN** ni la asignación, ni el partner, ni el setting global definen comisión
- **THEN** el sistema resuelve la comisión como 0
- **AND** el panel muestra las métricas monetarias en 0 sin lanzar error

#### Scenario: Comisión fuera de rango
- **WHEN** se intenta guardar una comisión menor que 0 o mayor que 100
- **THEN** la validación falla

### Requirement: Separación de acceso entre paneles
El sistema DEBE (SHALL) impedir que un miembro acceda al panel que no corresponde a su rol, redirigiéndolo al suyo en lugar de mostrar un error.

#### Scenario: Partner intenta abrir el panel de creador
- **WHEN** un miembro autenticado con `role = partner` solicita `/account/dashboard`
- **THEN** el sistema lo redirige a `/partner/dashboard`

#### Scenario: Creador intenta abrir el panel de partner
- **WHEN** un miembro autenticado con `role = creator` solicita `/partner/dashboard`
- **THEN** el sistema lo redirige a `/account/dashboard`

#### Scenario: Visitante sin sesión
- **WHEN** un visitante no autenticado solicita cualquier ruta bajo `/partner/`
- **THEN** el sistema lo redirige a la pantalla de login de miembros

#### Scenario: Redirección tras iniciar sesión
- **WHEN** un miembro con `role = partner` inicia sesión correctamente
- **THEN** aterriza en `/partner/dashboard`

### Requirement: Menú del panel según el rol
El menú lateral del panel DEBE (SHALL) mostrar únicamente las entradas correspondientes al rol del miembro autenticado.

#### Scenario: Menú de un partner
- **WHEN** un partner carga cualquier vista de su panel
- **THEN** el menú muestra sus propias entradas (estadísticas, cuentas, dominios, configuración)
- **AND** no muestra entradas exclusivas del creador como «Referidos»

#### Scenario: Menú de un creador
- **WHEN** un creador carga su panel
- **THEN** el menú es idéntico al actual, sin entradas de partner
