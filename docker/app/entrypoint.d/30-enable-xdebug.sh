#!/bin/sh

if [ "${XDEBUG_MODE}" = "off" ]; then
  echo "[XDebug] disabled. Skipping."
  return 0
fi
echo "[XDebug] Enabled and is being configured..."

CONFIG_FILE=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
if [ ! -f "${CONFIG_FILE}" ] ; then
  echo "[XDebug] Config file ${CONFIG_FILE} not found. Aborting."
  return 0
fi

export PHP_IDE_CONFIG=$PHP_IDE_CONFIG

XDEBUG_MODE=${XDEBUG_MODE:-debug}
XDEBUG_START_WITH_REQUEST=${XDEBUG_START_WITH_REQUEST:-yes}
XDEBUG_CLIENT_HOST=${XDEBUG_CLIENT_HOST:-host.docker.internal}
XDEBUG_CLIENT_PORT=${XDEBUG_CLIENT_PORT:-9003}
XDEBUG_CLIENT_IDEKEY=${XDEBUG_CLIENT_IDEKEY:-PHPSTORM}
XDEBUG_MAX_NESTING_LEVEL=${XDEBUG_MAX_NESTING_LEVEL:-1000}

cat <<EOF > "${CONFIG_FILE}"
zend_extension                 = xdebug.so
[xdebug]
xdebug.mode                    = $XDEBUG_MODE
xdebug.start_with_request      = $XDEBUG_START_WITH_REQUEST
xdebug.client_host             = $XDEBUG_CLIENT_HOST
xdebug.client_port             = $XDEBUG_CLIENT_PORT
xdebug.idekey                  = $XDEBUG_CLIENT_IDEKEY
xdebug.max_nesting_level       = $XDEBUG_MAX_NESTING_LEVEL
xdebug.output_dir              = /tmp/debug
xdebug.discover_client_host    = 0
xdebug.cli_color               = 1
EOF