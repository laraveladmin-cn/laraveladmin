FROM php:7.4-fpm
RUN sed -i "s@http://deb.debian.org@http://mirrors.aliyun.com@g" /etc/apt/sources.list && \
rm -Rf /var/lib/apt/lists/* && \
apt-get update && \
pecl channel-update pecl.php.net
#安装php扩展
RUN apt-get install -y \
        libfreetype6-dev \
        libtool \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libmcrypt-dev \
        libxml2 \
        libonig-dev \
        zip \
        unzip \
    ##安装扩展
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) bcmath \
    && docker-php-ext-install -j$(nproc) pdo \
    && docker-php-ext-install -j$(nproc) mbstring \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) opcache \
    && docker-php-ext-install -j$(nproc) mysqli \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) pcntl \
    && docker-php-ext-install -j$(nproc) tokenizer
##扩展安装
RUN pecl install redis-4.0.1 \
    && docker-php-ext-enable redis
RUN pecl install channel://pecl.php.net/mcrypt-1.0.3 \
    && docker-php-ext-enable mcrypt
RUN pecl install swoole && docker-php-ext-enable swoole

# 安装定时任务
RUN apt-get install -y cron && \
    touch /var/spool/cron/crontabs/root && \
    chown -R root:crontab /var/spool/cron/crontabs/root && \
    chmod 600 /var/spool/cron/crontabs/root && \
    touch /var/log/cron.log
#安装进程守护工具
RUN apt-get install -y supervisor
RUN apt-get install -y git
# 安装composer
RUN php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    mv composer.phar /usr/bin/composer && \
    chmod +x /usr/bin/composer && composer --version && \
    composer config -g repo.packagist composer https://mirrors.cloud.tencent.com/composer
# 用于数据库备份
RUN apt-get install -y default-mysql-client \
                   mariadb-client

ENV PATH /root/.composer/vendor/bin:$PATH
RUN chown -R www-data:www-data /var/www && \
    cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime && \
    apt-get clean && \
    rm -rf /tmp/pear &&\
    rm -rf /var/lib/apt/lists/* &&\
    docker-php-source delete
##工作目录
WORKDIR /var/www/laravel/laraveladmin
ENV LARAVEL_DIR /var/www/laravel

CMD [ "sh", "-c", "/var/www/laravel/laraveladmin/docker/php/run.sh" ]
EXPOSE 1215-1225
