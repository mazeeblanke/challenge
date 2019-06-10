# API Gateway

A simple web API gateway build on Laravel


Setup
-----------
#### Install vendor dependencies with Composer
Navigate to service's root directory:
```bash
cd api-gateway/
```

To install all composer dependencies, run the following command:
```bash
docker run --rm -v $(PWD):/app -v $($HOME)/.composer:/composer --user $(id -u):$(id -g) composer install --optimize-autoloader --no-interaction --no-progress --no-scripts
```
