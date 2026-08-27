#!/usr/bin/env bash
# Construye la base de datos sqlite que usa la suite de tests.
#
# Botble registra los service providers y las migraciones de cada plugin a partir
# del setting `activated_plugins`, que se lee de la BD *al arrancar*. Sobre una base
# vacía no hay plugins activos, así que sus migraciones nunca se ejecutan. De ahí las
# dos fases: se migra el core, se siembra `activated_plugins` y se vuelve a migrar en
# un arranque nuevo, que ya registra los providers de los plugins.
set -euo pipefail

cd "$(dirname "$0")/.."

DB_FILE="${1:-database/testing.sqlite}"
PLUGINS='["language","language-advanced","analytics","audit-log","backup","block","blog","captcha","contact","cookie-consent","custom-field","gallery","request-log","social-login","translation","brands","domain","admanager","member","partner"]'

echo "==> Recreando ${DB_FILE}"
rm -f "${DB_FILE}"
mkdir -p "$(dirname "${DB_FILE}")"
touch "${DB_FILE}"

export DB_CONNECTION=sqlite
export DB_DATABASE="${DB_FILE}"

echo "==> Fase 1: migraciones del core"
php artisan migrate --force --no-interaction >/dev/null

echo "==> Sembrando activated_plugins"
php artisan tinker --execute="\DB::table('settings')->updateOrInsert(['key' => 'activated_plugins'], ['key' => 'activated_plugins', 'value' => '${PLUGINS}']);" >/dev/null

echo "==> Fase 2: migraciones de los plugins"
php artisan migrate --force --no-interaction >/dev/null

echo "==> Comprobando tablas"
for table in members domains partner_networks settings; do
    result=$(php artisan tinker --execute="echo \Illuminate\Support\Facades\Schema::hasTable('${table}') ? 'ok' : 'FALTA';" 2>/dev/null | tail -1)
    echo "    ${table}: ${result}"
    if [ "${result}" != "ok" ]; then
        echo "ERROR: falta la tabla ${table}" >&2
        exit 1
    fi
done

echo "==> Base de tests lista en ${DB_FILE}"
