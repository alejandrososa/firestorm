# Docker Symfony Firestorm

Docker symfony gives you everything you need for developing Symfony application. This complete stack run with docker and [docker-compose](https://docs.docker.com/compose/).

## Installation step by step

1. Install [docker](https://docs.docker.com/compose/install/) and [docker-compose](https://docs.docker.com/compose/install/#install-compose)

2. Build/run containers with (with and without detached mode)

    ```bash
    $ docker-compose build
    $ docker-compose up -d
    ```

3. Update your system host file (add firestorm.local)

    ```bash
    # UNIX only: get containers IP address and update host (replace IP according to your configuration) (on Windows, edit C:\Windows\System32\drivers\etc\hosts)
    $ sudo echo "127.0.0.1 firestorm.local" >> /etc/hosts
    ```

    **Note:** For **OS X**, please take a look [here](https://docs.docker.com/docker-for-mac/networking/) and for **Windows** read [this](https://docs.docker.com/docker-for-windows/#/step-4-explore-the-application-and-run-examples) (4th step).

4. Prepare Backend app

    1. Go to root directory
    2. Composer install

        ```bash
        $ docker-compose exec php composer install
        ```

5. Enjoy :-)

* Visit [firestorm.local](http://firestorm.local)  


## Usage

Just run `docker-compose up -d`, then:

* App: visit [firestorm.local](http://firestorm.local)  

## How it works?

Have a look at the `docker-compose.yml` file, here are the `docker-compose` built images:

* `nginx`: This is the server container
* `redis`: This is the cache system container
* `php`: This is the PHP-FPM and Apache2 container in which the application volume is mounted

This results in the following running containers:

```bash
$ docker-compose ps 

      Name                     Command               State                Ports              
---------------------------------------------------------------------------------------------
firestorm_nginx_1   nginx                            Up      443/tcp, 0.0.0.0:8081->80/tcp   
firestorm_php_1     docker-php-entrypoint php- ...   Up      9000/tcp, 0.0.0.0:9001->9001/tcp
firestorm_redis_1   docker-entrypoint.sh redis ...   Up      0.0.0.0:6379->6379/tcp  

```

## Useful commands

```bash
# bash commands
$ docker-compose exec php sh

# Composer (e.g. composer update)
$ docker-compose exec php composer update

# Symfony commands
$ docker-compose exec php /var/www/bin/console cache:clear 
$ docker-compose exec php sh
$ php bin/console cache:clear

# Retrieve an IP Address (here for the nginx container)
$ docker inspect $(docker ps -f name=nginx -q) | grep IPAddress

# F***ing cache/logs folder
$ sudo chmod -R 777 var/cache var/log var/sessions 

# Check CPU consumption
$ docker stats $(docker inspect -f "{{ .Name }}" $(docker ps -q))

# Delete all containers
$ docker rm $(docker ps -aq)

# Delete all images
$ docker rmi $(docker images -q)
```

## FAQ

* Got this error: `ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?
If it's at a non-standard location, specify the URL with the DOCKER_HOST environment variable.` ?  
Run `docker-compose up -d` instead.

* Permission problem? See [this doc (Setting up Permission)](http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup)