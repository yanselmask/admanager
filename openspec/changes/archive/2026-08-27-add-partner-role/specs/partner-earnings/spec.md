## ADDED Requirements

### Requirement: Alcance de los datos del partner
Las métricas de un partner DEBEN (SHALL) calcularse exclusivamente sobre los dominios cuyo `network_code` está asignado a ese partner en `partner_networks`. El sistema NO DEBE (SHALL NOT) filtrar por `member_id` del dominio: un partner ve todos los dominios de sus networks, tengan o no un creador asignado.

#### Scenario: Agregación sobre las networks del partner
- **WHEN** un partner tiene asignadas las networks `123456` y `789012`
- **AND** existen 5 dominios en `123456` y 3 en `789012`
- **THEN** sus métricas agregan los 8 dominios

#### Scenario: Dominios ajenos excluidos
- **WHEN** existe un dominio con `network_code = 555555`, no asignado a ningún partner
- **THEN** ese dominio no aparece en las métricas de ningún partner

#### Scenario: Dominio sin creador
- **WHEN** un dominio de una network del partner tiene `member_id` nulo
- **THEN** igualmente se incluye en las métricas del partner

#### Scenario: Aislamiento entre partners
- **WHEN** el partner A consulta sus métricas
- **THEN** ningún dominio de las networks del partner B aparece en el resultado

### Requirement: Base de cálculo de la ganancia
El sistema DEBE (SHALL) calcular la ganancia de un dominio para el partner aplicando su comisión sobre una base determinada por el setting `partner_earning_base`, que admite dos valores: `platform_net` (valor por defecto) y `gross`. Los valores crudos de `domains.earnings` están expresados en micros y DEBEN (SHALL) dividirse entre 1.000.000 antes de cualquier cálculo.

#### Scenario: Base platform_net
- **WHEN** `partner_earning_base` vale `platform_net`
- **AND** un dominio tiene `earnings["today"] = 100000000` (100 unidades), `commissions = 60` y `commissions_network = 15`
- **AND** la comisión resuelta del partner es 10
- **THEN** la base es `100 × (60 − 15) / 100 = 45`
- **AND** la ganancia del partner para ese dominio es `45 × 10 / 100 = 4.50`

#### Scenario: Base gross
- **WHEN** `partner_earning_base` vale `gross`
- **AND** un dominio tiene `earnings["today"] = 100000000` (100 unidades)
- **AND** la comisión resuelta del partner es 10
- **THEN** la ganancia del partner para ese dominio es `100 × 10 / 100 = 10.00`

#### Scenario: Comisiones del dominio sin definir
- **WHEN** `partner_earning_base` vale `platform_net`
- **AND** un dominio tiene `commissions` nulo
- **THEN** el sistema usa el setting `percentage_default` como `commissions`
- **AND** trata `commissions_network` nulo como 0

#### Scenario: Base negativa
- **WHEN** `commissions_network` es mayor que `commissions` en un dominio
- **THEN** la base de ese dominio se trunca a 0
- **AND** su aporte a la ganancia del partner es 0, sin restar de otros dominios

#### Scenario: Periodo sin datos
- **WHEN** un dominio no tiene la clave del periodo solicitado en su JSON `earnings`
- **THEN** su aporte a la ganancia es 0 y no se lanza ningún error

### Requirement: Comisión por network en la agregación
Cuando distintas networks de un mismo partner tienen comisiones distintas, el sistema DEBE (SHALL) aplicar a cada dominio la comisión de la network a la que pertenece, y sumar después.

#### Scenario: Networks con comisiones distintas
- **WHEN** un partner tiene la network `123456` al 10% y la network `789012` al 15%
- **AND** los dominios de `123456` producen una base total de 100 y los de `789012` una base total de 200
- **THEN** su ganancia total es `100 × 0.10 + 200 × 0.15 = 40`

### Requirement: Métricas de volumen y derivadas
El panel del partner DEBE (SHALL) exponer, además de la ganancia: impresiones, clicks, CTR y eCPM. Las impresiones y los clicks son sumas crudas de los dominios incluidos, sin aplicar ningún porcentaje. El CTR y el eCPM se recalculan a partir de los totales agregados, nunca promediando los valores por dominio.

#### Scenario: Suma de impresiones y clicks
- **WHEN** los dominios del partner suman 10.000 impresiones y 250 clicks en el periodo
- **THEN** el panel muestra 10.000 impresiones y 250 clicks

#### Scenario: Cálculo del CTR
- **WHEN** el total agregado es 10.000 impresiones y 250 clicks
- **THEN** el CTR mostrado es `250 / 10000 × 100 = 2.50%`

#### Scenario: Cálculo del eCPM
- **WHEN** la ganancia del partner en el periodo es 45.00 y las impresiones agregadas son 10.000
- **THEN** el eCPM mostrado es `45.00 / 10000 × 1000 = 4.50`

#### Scenario: División por cero
- **WHEN** las impresiones agregadas del periodo son 0
- **THEN** el CTR y el eCPM se muestran como 0 sin lanzar error

### Requirement: Métricas por periodo
El sistema DEBE (SHALL) calcular las métricas del partner para el periodo solicitado, usando las mismas claves de periodo que ya emplean las columnas JSON de `domains` (`today`, `yesterday`, `this_week`, `this_month`, `this_year`, …). Si no se indica periodo, DEBE (SHALL) usarse `today`.

#### Scenario: Periodo explícito
- **WHEN** el partner solicita el periodo `this_month`
- **THEN** todas las métricas se calculan leyendo la clave `this_month` de los JSON de los dominios

#### Scenario: Periodo omitido
- **WHEN** el partner abre su panel sin indicar periodo
- **THEN** las métricas corresponden a `today`

#### Scenario: Periodo desconocido
- **WHEN** se solicita un periodo que no está entre los configurados
- **THEN** el sistema recae en `today` en lugar de fallar

### Requirement: Desglose por network
El sistema DEBE (SHALL) poder devolver las métricas del partner desglosadas por network, además del total agregado, con las mismas reglas de cálculo.

#### Scenario: Desglose de un partner con dos networks
- **WHEN** un partner con las networks `123456` y `789012` consulta sus métricas
- **THEN** obtiene una fila por network con su ganancia, impresiones, clicks, CTR y eCPM
- **AND** la suma de las ganancias por network coincide con la ganancia total mostrada

#### Scenario: Network sin dominios
- **WHEN** una network asignada al partner no tiene ningún dominio registrado
- **THEN** aparece en el desglose con todas sus métricas en cero
