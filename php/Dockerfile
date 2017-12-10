# Simple PHP application
FROM ubuntu:16.04

RUN apt update
RUN apt install -y \
	build-essential \
	cmake \
	git \
	libpcre3-dev \
	php7.0-dev \
	libgmp-dev \
	wget \
	php7.0-fpm

RUN wget http://downloads.datastax.com/cpp-driver/ubuntu/16.04/dependencies/libuv/v1.11.0/libuv_1.11.0-1_amd64.deb
RUN wget http://downloads.datastax.com/cpp-driver/ubuntu/16.04/dependencies/libuv/v1.11.0/libuv-dev_1.11.0-1_amd64.deb
RUN dpkg -i libuv_1.11.0-1_amd64.deb
RUN dpkg -i libuv-dev_1.11.0-1_amd64.deb

RUN apt install -y libssl-dev

RUN wget http://downloads.datastax.com/cpp-driver/ubuntu/16.04/cassandra/v2.7.1/cassandra-cpp-driver_2.7.1-1_amd64.deb
RUN wget http://downloads.datastax.com/cpp-driver/ubuntu/16.04/cassandra/v2.7.1/cassandra-cpp-driver-dev_2.7.1-1_amd64.deb
RUN dpkg -i cassandra-cpp-driver_2.7.1-1_amd64.deb
RUN dpkg -i cassandra-cpp-driver-dev_2.7.1-1_amd64.deb

RUN pecl install cassandra

RUN php -r "echo php_ini_loaded_file();"

COPY docker.conf /etc/php/7.0/fpm/conf.d/docker.conf
COPY zz_docker.conf /etc/php/7.0/fpm/conf.d/zz_docker.conf
COPY www.conf /etc/php/7.0/fpm/conf.d/www.conf

RUN echo 'extension=cassandra.so' >> /etc/php/7.0/fpm/php.ini
RUN echo 'include=/etc/php/7.0/fpm/conf.d/*.conf' >> /etc/php/7.0/fpm/php-fpm.conf

RUN mkdir /run/php

EXPOSE 9000

CMD ["/usr/sbin/php-fpm7.0", "--nodaemonize"]
