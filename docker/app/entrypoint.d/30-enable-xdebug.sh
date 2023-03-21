#!/bin/sh

if [ ! "${DOCKER_ENABLE_XDEBUG}" = "1" ]; then
  echo "XDebug disabled. Skipping."
  return 0
fi
echo "Configuring XDebug."

CONFIG_FILE=/etc/php/8.1/cli/conf.d/20-xdebug.ini
if [ ! -f "${CONFIG_FILE}" ] ; then
  echo "XDebug config file ${CONFIG_FILE} not found. Aborting."
  return 0
fi

XDEBUG_CONFIG_MODE=off
if [ ! -z "${XDEBUG_MODE}" ]; then
  XDEBUG_CONFIG_MODE=${XDEBUG_MODE}
fi

touch "${CONFIG_FILE}"
cat <<EOF > "${CONFIG_FILE}"
zend_extension=xdebug.so
EOF

echo "xdebug.mode=${XDEBUG_CONFIG_MODE}" >> ${CONFIG_FILE};
echo "xdebug.start_with_request=yes"  >> ${CONFIG_FILE};
if [ -n "${XDEBUG_SESSION}" ] ; then
   echo "xdebug.session=${XDEBUG_SESSION}" >> ${CONFIG_FILE};
fi
if [ -n "${XDEBUG_CLIENT_HOST}" ] ; then
   echo "xdebug.client_host=${XDEBUG_CLIENT_HOST}" >> ${CONFIG_FILE};
fi
if [ -n "${XDEBUG_CLIENT_PORT}" ] ; then
   echo "xdebug.client_port=${XDEBUG_CLIENT_PORT}" >> ${CONFIG_FILE};
fi

echo "Success."
