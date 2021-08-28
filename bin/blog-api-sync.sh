#!/bin/bash

#Synchronizace uživatelů z externího API
php bin/console blog:api:user:sync --env=dev

# Synchronizace článků z externího API
php bin/console blog:api:post:sync --env=dev

# Synchronizace komentářů z externího API
php bin/console blog:api:comment:sync --env=dev