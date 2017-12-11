# Compile Nginx for Ubuntu16.04
FROM ubuntu:16.04

RUN apt update
RUN apt upgrade -y
RUN apt install -y \
	build-essential \
	wget
RUN wget https://nginx.org/download/nginx-1.13.1.tar.gz && tar zxvf nginx-1.13.1.tar.gz && \
	wget https://ftp.pcre.org/pub/pcre/pcre-8.40.tar.gz && tar xzvf pcre-8.40.tar.gz && \
	wget http://www.zlib.net/zlib-1.2.11.tar.gz && tar xzvf zlib-1.2.11.tar.gz && \
	wget https://www.openssl.org/source/openssl-1.1.0f.tar.gz && tar xzvf openssl-1.1.0f.tar.gz


RUN apt install -y \
	libxml2-dev \
	libxslt1-dev
RUN apt install -y libgd-dev
RUN apt install -y libgeoip-dev

WORKDIR /openssl-1.1.0f
RUN ./config -fPIE && \
	make && \
	make install
WORKDIR /nginx-1.13.1
RUN ./configure --with-cc-opt='-g -O2 -fPIE -fstack-protector-strong -Wformat -Werror=format-security -Wdate-time -D_FORTIFY_SOURCE=2' --with-ld-opt='-Wl,-Bsymbolic-functions -fPIE -pie -Wl,-z,relro -Wl,-z,now' --prefix=/usr/share/nginx --conf-path=/etc/nginx/nginx.conf --http-log-path=/var/log/nginx/access.log --error-log-path=/var/log/nginx/error.log --lock-path=/var/lock/nginx.lock --pid-path=/run/nginx.pid --http-client-body-temp-path=/var/lib/nginx/body --http-fastcgi-temp-path=/var/lib/nginx/fastcgi --http-proxy-temp-path=/var/lib/nginx/proxy --http-scgi-temp-path=/var/lib/nginx/scgi --http-uwsgi-temp-path=/var/lib/nginx/uwsgi --with-debug --with-pcre-jit --with-ipv6 --with-http_ssl_module --with-http_stub_status_module --with-http_realip_module --with-http_auth_request_module --with-http_addition_module --with-http_dav_module --with-http_geoip_module --with-http_gunzip_module --with-http_gzip_static_module --with-http_image_filter_module --with-http_v2_module --with-http_sub_module --with-http_xslt_module --with-stream --with-stream_ssl_module --with-mail --with-mail_ssl_module --with-threads \
	--with-pcre=../pcre-8.40 \
	--with-openssl=../openssl-1.1.0f \
	--with-zlib=../zlib-1.2.11

RUN make
RUN apt install -y checkinstall
RUN	checkinstall --install=no 

RUN mkdir /package

VOLUME /package
RUN cp *.deb /package/.
