FROM dunglas/frankenphp

RUN install-php-extensions \
    ctype \
    curl \
    dom \
    exif \
    fileinfo \
    filter \
    gd \
    hash \
    intl \
    mbstring \
    mongodb \
    opcache \
    openssl \
    pcre \
    pdo \
    pdo_mysql \
    session \
    tokenizer \
    xml \
    pcntl

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
