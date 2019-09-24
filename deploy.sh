#!/bin/bash

buildDocker(){
    docker-compose up -d
    echo -ne '\n' | docker-compose exec php sh
}

deployBackend(){
    docker-compose exec php composer install
}

buildDocker
deployBackend

echo "----------------"
echo "DEPLOY FINISHED \n"
echo "Enjoy :) \n"