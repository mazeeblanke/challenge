# Scratchpay-challenge

Set up
------------

#### Install Docker
The current Docker environment is based on Docker Toolbox.
If you don't have Docker Toolbox installed, you can download it [here](https://www.docker.com/products/docker-toolbox).


#### Create a docker-machine *
```
    docker-machine create scratchpay-challenge
    eval $(docker-machine env scratchpay-challenge)
```

#### Create the external network
```
    docker network create traefik_webgateway
```

Setup all services
------------
In order to get up and running, you need to setup each
individual service.

- [logger-interface](logger-interface/readme.md)
- [pubsub-interface](pubsub-interface/readme.md)
- [api gateway](api-gateway/readme.md)

Once you set all services, you are ready to use them.

Build & Run
------------
```
    docker-compose -f docker/docker-compose.yml up -d --build

```

Run Tests

```phpunit```

Access
------------
You can access the api gateway from:
```
    #api gateway
    http://api-gateway.docker.lm.localhost
```

#### Reverse proxies
You can access Traefik interface from:
```
    http://lm.local:8080
```

Teardown and "Scale"
------------
#### Teardown
```
    docker-compose -f docker/docker-compose.yml down --volumes --remove-orphans
```

#### Scale
```
    # DEPRECATED
    docker-compose -f docker/docker-compose.yml scale ${container-name}
```

