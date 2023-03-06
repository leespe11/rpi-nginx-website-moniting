#!/bin/bash
set -a
source config.env
docker-compose stop nginx
rm -rf /etc/letsencrypt/archive/*
rm -rf /etc/letsencrypt/live/*
rm -rf /etc/letsencrypt/renewal/*
certbot certonly --manual --preferred-challenges=dns --email $EMAIL --server https://acme-v02.api.letsencrypt.org/directory --agree-tos -d *.$DOMAIN_NAME -d $DOMAIN_NAME
docker-compose start nginx