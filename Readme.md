# Scratchpay-challenge

Set up
------------

#### Install Docker
The current Docker environment is based on Docker Toolbox.
If you don't have Docker Toolbox installed, you can download it [here](https://www.docker.com/products/docker-toolbox).


Setup all services
------------
The docker-compose.yml file contains all instructions that relate to setting up and deploying the services.

In order to get up and running, you do not need to make any changes, as the images have been built and pushed to dockerhub.

However, for any changes made to reflect, you will need to rebuild that particular service, push the image to [dockerhub]("https://cloud.docker.com") and update the docker-compose.yml file.

The services are:
- [logger-interface](logger-interface) : This idea here is all the different instances of this service can log entries to the redis service.
- [pubsub-interface](pubsub-interface)
- [api gateway](api-gateway): This is the single entry point of the api

To install the composer dependencies, cd into the service directory e.g ``` cd api-gateway ```, then Run:

``` docker run --rm -v ${pwd}:/var/www/api-gateway composer/composer install  ``` ---  for powershell

or

``` docker run --rm -v "%cd%":/var/www/api-gateway composer/composer install ```  --- for simple CMD shell session

or

``` docker run --rm -v $(pwd):/var/www/api-gateway composer/composer install ```

This enables us to use composer without installing it globally on our local system

NB: For a more advanced setup I would use kubernetes to achieve a better result.

Build & Run
------------
In order to maintain simplicity for the purposes of this project, I have decided to use [docker-swam]("https://docs.docker.com/engine/swarm/swarm-tutorial/") as the container orchestration engine with a single node in the swarm.

It requires the following steps:

1) Initialize docker swarm. open the terminal window in the project root and run:
    ```docker swarm init ```
2) create a swam scoped network ``` docker network create -d overlay webgateway```
3) Then run: ``` docker stack deploy -c docker-compose.yml scratchpay ```
This creates a service stack is running 5 container instances of the 'logger-interface service' and 3 container instances of the 'pubsub-interface service' deployed on one host in the swarm.

NB: 'scratchpay' in the command above is the name of our app

Debug
-------------

To Investigate, run:
``` docker stack services scratchpay ```

To view all tasks of the stack, run:
``` docker stack ps scratchpay ```

To view logs of a service run:
    ``` docker service logs -f [name of service] ```

Get lists of services through: ``` docker service ls ```

Run Tests

```phpunit```

Access
------------
The API gateway is the only entrypoint and can be accessed from
```
    #api gateway

    http://localhost:4500/api/v1/businessDates/getBusinessDateWithDelay
```


Teardown
------------
#### Teardown
Take down the app and the swarm
``` docker stack rm scratchpay ```
Take down the swarm.

``` docker swarm leave --force ```



