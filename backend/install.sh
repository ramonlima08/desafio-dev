#!/bin/bash
GREEN='\033[01;32m'
NC='\033[0m' #no color

echo -e "${GREEN}-----------------------------${NC}"
echo -e "${GREEN}Executando instalação ...${NC}"
composer install &&
echo -e "${GREEN}Copiando .env${NC}"
cp .env.example .env &&
echo -e "${GREEN}Gerando key${NC}"
php artisan key:generate && 
echo -e "${GREEN}Executando as migrations${NC}"
php artisan migrate && 
echo -e "${GREEN}Executando as seeds${NC}"
php artisan db:seed 
echo -e "${GREEN}-----------------------------${NC}"
echo -e "${GREEN}Instalação executada com sucess!${NC}"