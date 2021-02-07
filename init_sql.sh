#!/bin/sh
docker-compose exec sql bash -c "chmod 0775 docker-entrypoint-initdb.d/init.sh"
docker-compose exec sql bash -c "./docker-entrypoint-initdb.d/init.sh"
