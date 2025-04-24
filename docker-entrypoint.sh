#!/usr/bin/env bash
set -e

# Ensure Laravel can write to storage, cache and license folders
mkdir -p storage/license
chown -R www-data:www-data storage bootstrap/cache storage/license

# Delegate to the original command (apache2-foreground)
exec "$@"
