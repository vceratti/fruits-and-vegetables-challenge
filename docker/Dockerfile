FROM php:8.4-fpm-alpine3.21 AS base

ARG APP_ENV
RUN apk add --no-cache git

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions zip bcmath @composer;

WORKDIR /app

FROM base AS dev

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG COMPOSER_MEMORY_LIMIT=-1

RUN addgroup -g ${GROUP_ID} app && \
    adduser -D -u ${USER_ID} -G app app && \
    mkdir -p /opt/phpstorm-coverage && \
    chmod a+rw /opt/phpstorm-coverage && \
    chown app:app -R /app /opt/phpstorm-coverage;


RUN install-php-extensions xdebug && \
    rm /usr/local/bin/install-php-extensions;

USER app