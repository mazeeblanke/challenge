FROM php:7.3-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev nginx

# COPY vhost.conf /etc/nginx/conf.d/default.conf
COPY vhost.conf /etc/nginx/sites-enabled/default
COPY entrypoint.sh /etc/entrypoint.sh

# # Copy the current directory contents into the container at /app
# COPY . /app

EXPOSE 80

ENTRYPOINT ["/etc/entrypoint.sh"]

