# pre build latest
# 빌드 전 필수로 설치해야하는 서비스 사전 설치
# 미리 이미지화 하여 해당 이미지 참조
FROM centos:7

#package manager 설치
RUN yum update -y && \
    yum install -y epel-release

#php 설치
RUN yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm && \
    yum install -y yum-utils && \
    yum-config-manager --enable remi-php74 && \
    yum -y update

#php extension 설치
RUN yum install -y php-fpm php-xml php-cli php-json php-bcmath unzip php-zip php-dba php-gd php-intl php-mbstring mariadb-server php-mysql php-pdo php-soap php-pecl-apcu php-pecl-imagick php-mongodb

#유저 생성
RUN useradd -M -d /app -s /bin/false nginx

#php-fpm 폴더 생성 및 권한 부여
RUN mkdir -p /run/php-fpm && \
    chown nginx:nginx /run/php-fpm

#php session 폴더 생성 및 권한 부여
RUN mkdir -p /var/lib/php/session && \
    chown nginx:nginx /var/lib/php/session

#php-fpm 설정파일 복제
COPY php/php-fpm.conf /etc/php-fpm.conf
COPY php/www.conf /etc/php-fpm.d/www.conf
COPY php/php.ini /etc/php.ini

#nginx 설치
RUN yum -y install nginx

#nginx 설정파일 복제
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/app.conf /etc/nginx/conf.d/app.conf

########################################## 기타 설치 파일 #############################################
#composer 설치
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer

#nodejs 설치
RUN curl -sL https://rpm.nodesource.com/setup_12.x | bash -
RUN yum install -y gcc-c++ make
RUN yum install -y nodejs

# 라라벨 설치
RUN composer global require laravel/installer

# 컴포저 패스 지정
RUN ["/bin/bash", "-c", "echo PATH=$PATH:~/.composer/vendor/bin/ >> ~/.bashrc"]
RUN ["/bin/bash", "-c", "source ~/.bashrc"]

# supervisor 설치(관리자)
RUN yum install -y supervisor

# 설정파일 복제
COPY supervisord.conf /etc/supervisord.d/supervisord.conf

