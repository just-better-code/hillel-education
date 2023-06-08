#!/bin/sh

echo "Deploy app files."

composer
composer install --quiet

echo "Application deployed."
