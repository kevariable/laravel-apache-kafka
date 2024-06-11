FROM dunglas/frankenphp

WORKDIR /var/www/html

RUN apt-get update -y && apt-get upgrade -y \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - &&\
        apt-get install -y nodejs \
    && install-php-extensions \
        pcntl rdkafka \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s @composer

COPY --link --chown=www-data:www-data composer.* ./
RUN composer install --no-dev --no-cache --no-autoloader --no-scripts

COPY --link --chown=www-data:www-data ./ .
RUN composer dump-autoload --no-dev --classmap-authoritative

COPY --chown=www-data:www-data package*.json .
RUN npm install

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh