# Docker + Symfony: Firestorm App with CQRS and Event Sourcing

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

* Visit [firestorm.local:8081](http://firestorm.local:8081)  


## Usage

Just run `docker-compose up -d`, then:

* App: visit [firestorm.local:8081](http://firestorm.local:8081)  

**cURL**

```bash
$ curl -X POST http://firestorm.local:8081/api/v1/missile/calculate-area \
    -F uuid=e856c897-bd9e-4c2d-815a-220bd56605fa -F precision=100
  
Result:                                                                 
    Success

-----

$ curl -X GET http://firestorm.local:8081/api/v1/missile/calculate-area/e856c897-bd9e-4c2d-815a-220bd56605fa
   
Result:                                                                
    {
        "response": {
            "area": 0.006666666666666667,
            "weather": {
                "wind": "broken clouds, 2.10 m/s Barcelona ( 160.00 )",
                "humidity": "78%"
            }
        }
    }
```

**Bash**

```bash
$ docker-compose exec php php bin/console firestorm:calculate-area 1cd56a54-e119-11e9-81b4-2a2ae2dbcce4 12000
  
Result:                                                                
    Calculate Area
    ============
    Uuid: 1cd56a54-e119-11e9-81b4-2a2ae2dbcce4
    precision: 12000
                                                                        
    [OK] Success!   


$ docker-compose exec php php bin/console firestorm:get-area-by-id 1cd56a54-e119-11e9-81b4-2a2ae2dbcce4
   
Result:                                                                
    Get Area by Id
    ============
    Uuid: 1cd56a54-e119-11e9-81b4-2a2ae2dbcce4
    
     {
        "response": {
            "area": 0.11273333333333334,
            "weather": {
                "wind": "broken clouds, 2.10 m\/s Barcelona ( 160.00 )",
                "humidity": "78%"
            }
        }
    }
```

**Testing**

```bash
$ docker-compose exec php cp phpunit.xml.dist phpunit.xml 
$ docker-compose exec php ./vendor/bin/phpunit

PHPUnit 7.5.16 by Sebastian Bergmann and contributors.

...................................                               35 / 35 (100%)

Time: 865 ms, Memory: 28.00 MB

OK (35 tests, 65 assertions)

-------

$ docker-compose exec php ./vendor/bin/phpunit --coverage-text 

PHPUnit 7.5.16 by Sebastian Bergmann and contributors.

...................................                               35 / 35 (100%)

Time: 1.41 seconds, Memory: 18.00 MB

OK (35 tests, 65 assertions)


Code Coverage Report:      
  2019-09-27 11:42:14      
                           
 Summary:                  
  Classes: 62.50% (15/24)  
  Methods: 79.22% (61/77)  
  Lines:   79.62% (211/265)

\Firestorm::Firestorm\Kernel
  Methods:  50.00% ( 2/ 4)   Lines:  31.58% (  6/ 19)
\Firestorm\MonCalamari\Application\Command::Firestorm\MonCalamari\Application\Command\CalculateArea
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% (  5/  5)
\Firestorm\MonCalamari\Application\Command::Firestorm\MonCalamari\Application\Command\CalculateAreaHandler
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% ( 18/ 18)
\Firestorm\MonCalamari\Application\Event::Firestorm\MonCalamari\Application\Event\AttachWeatherToMissile
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  3/  3)
\Firestorm\MonCalamari\Application\Event::Firestorm\MonCalamari\Application\Event\AttachWeatherToMissileHandler
  Methods:  75.00% ( 3/ 4)   Lines:  89.29% ( 25/ 28)
\Firestorm\MonCalamari\Application\Exception::Firestorm\MonCalamari\Application\Exception\AreaNotFound
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  1/  1)
\Firestorm\MonCalamari\Application\Exception::Firestorm\MonCalamari\Application\Exception\CalculatedAreaAlreadyExists
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  1/  1)
\Firestorm\MonCalamari\Application\Query::Firestorm\MonCalamari\Application\Query\GetAreaById
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  3/  3)
\Firestorm\MonCalamari\Application\Query::Firestorm\MonCalamari\Application\Query\GetAreaByIdHandler
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% (  9/  9)
\Firestorm\MonCalamari\Application\Transformer::Firestorm\MonCalamari\Application\Transformer\MissileArrayTransformer
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  6/  6)
\Firestorm\MonCalamari\Domain\Events::Firestorm\MonCalamari\Domain\Events\MissileWasConfiguredWithAttackArea
  Methods:  33.33% ( 1/ 3)   Lines:  81.82% (  9/ 11)
\Firestorm\MonCalamari\Domain\Events::Firestorm\MonCalamari\Domain\Events\MissileWasUpdatedWithWeather
  Methods:  33.33% ( 1/ 3)   Lines:  69.23% (  9/ 13)
\Firestorm\MonCalamari\Domain\Model::Firestorm\MonCalamari\Domain\Model\AggregateRoot
  Methods:  50.00% ( 1/ 2)   Lines:  66.67% (  6/  9)
\Firestorm\MonCalamari\Domain\Model\Missile::Firestorm\MonCalamari\Domain\Model\Missile\MissileArea
  Methods: 100.00% ( 7/ 7)   Lines: 100.00% ( 16/ 16)
\Firestorm\MonCalamari\Domain\Model\Missile::Firestorm\MonCalamari\Domain\Model\Missile\MissileId
  Methods: 100.00% ( 5/ 5)   Lines: 100.00% (  7/  7)
\Firestorm\MonCalamari\Domain\Model\Missile::Firestorm\MonCalamari\Domain\Model\Missile\MissileSensor
  Methods: 100.00% ( 6/ 6)   Lines: 100.00% ( 10/ 10)
\Firestorm\MonCalamari\Domain\Model\Missile::Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile
  Methods:  88.89% ( 8/ 9)   Lines:  94.74% ( 18/ 19)
\Firestorm\MonCalamari\Infrastructure\Persistence::Firestorm\MonCalamari\Infrastructure\Persistence\RedisSensorRepository
  Methods:  33.33% ( 1/ 3)   Lines:  45.45% (  5/ 11)
\Firestorm\MonCalamari\Ui\Api\Controller::Firestorm\MonCalamari\Ui\Api\Controller\CalculateAreaController
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  7/  7)
\Firestorm\MonCalamari\Ui\Api\Controller::Firestorm\MonCalamari\Ui\Api\Controller\GetAreaByIdController
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  5/  5)
\Firestorm\MonCalamari\Ui\Console\Command::Firestorm\MonCalamari\Ui\Console\Command\CalculateAreaCommand
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% ( 21/ 21)
\Firestorm\MonCalamari\Ui\Console\Command::Firestorm\MonCalamari\Ui\Console\Command\GetAreaByIdCommand
  Methods: 100.00% ( 4/ 4)   Lines: 100.00% ( 21/ 21)


```

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
# bash commands access to container php
$ docker-compose exec php sh

# Composer (e.g. composer install or composer update)
$ docker-compose exec php composer install
$ docker-compose exec php composer update

# Symfony commands
$ docker-compose exec php php bin/console                                   #list of commands available
$ docker-compose exec php php bin/console cache:clear                       #clear cache
$ docker-compose exec php php bin/console cache:pool:clear cache.app        #clear cache redis
$ docker-compose exec php php bin/console firestorm:calculate-area -h       #show help to calculate area
$ docker-compose exec php php bin/console firestorm:calculate-area uuid precision      
$ docker-compose exec php php bin/console firestorm:get-area-by-id -h       #show help to get calculated area
$ docker-compose exec php php bin/console firestorm:get-area-by-id uuid       

# Retrieve an IP Address (here for the nginx container)
$ docker inspect $(docker ps -f name=nginx -q) | grep IPAddress

# F***ing cache/logs folder
$ sudo chmod -R 777 var/cache var/log var/sessions 

# Check CPU consumption
$ docker stats $(docker inspect -f "{{ .Name }}" $(docker ps -q))

# Stop all containers
$ docker container stop $(docker container ls -aq)

# Delete all containers
$ docker rm $(docker ps -aq)
$ docker container rm $(docker container ls -aq)

# Delete all images
$ docker rmi $(docker images -q)
```



## FAQ

* Got this error: `ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?
If it's at a non-standard location, specify the URL with the DOCKER_HOST environment variable.` ?  
Run `docker-compose up -d` instead.

* Permission problem? See [this doc (Setting up Permission)](http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup)