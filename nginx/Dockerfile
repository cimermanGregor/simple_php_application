# Precompiled Nginx web server
FROM ubuntu:16.04

RUN apt update
RUN apt install nginx -y
RUN rm /etc/nginx/sites-enabled/default

VOLUME /www
EXPOSE 80

CMD nginx -g 'daemon off;'
