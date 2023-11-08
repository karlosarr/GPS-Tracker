#!/bin/bash

rm -rf bootstrap/cache/*.php

cp -n docker/.env.example .env
cp -n docker/docker-compose.yml.example docker/docker-compose.yml

docker compose -f docker/docker-compose.yml build
