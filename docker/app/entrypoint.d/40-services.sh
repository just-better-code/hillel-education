#!/bin/sh

echo "Running crontab."
cron -l 8
echo "Done."

echo "Running supervisor."
/usr/bin/supervisord
echo "Done."
