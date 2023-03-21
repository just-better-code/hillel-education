#!/bin/bash

# Exit the script if any statement returns a non-true return value
set -e

for file in ./docker/app/entrypoint.d/*.sh
do
  source "$file"
done

exec "$@"
