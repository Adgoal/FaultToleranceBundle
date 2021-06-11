FROM php:7.3-cli-alpine

RUN apk add git unzip autoconf gcc make g++ zlib-dev

# -------------------- Installing PHP Extension: amqp --------------------
RUN set -eux \
    # Installation: Generic
    # Type:         Built-in extension
    # Custom:       configure command
    && apk add rabbitmq-c-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && true

# -------------------- Installing PHP Extension: redis --------------------
RUN set -eux \
    # Installation: Generic
    # Type:         PECL extension
    # Default:      Pecl command
    && pecl install redis \
    && docker-php-ext-enable redis \
    && true

COPY php.ini /usr/local/etc/php/conf.d/default-php.ini
