# 실제 빌드 후 배포 나가야 하는 이미지
#FROM pre-build:latest
FROM prebuild:t1
#Dockerfile Env 세팅
# dev or production
# .env와 npm run 에 영향줌

ARG ENV_SERVER=dev

RUN mkdir -p /var/www/html

# 현재 디렉토리 /var/www/html로 복제 ( 경로가 중요할까?)
COPY . /var/www/html
COPY ./.docker/env-$ENV_SERVER /var/www/html/.env

WORKDIR /var/www/html

#파일 권한 변경
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views
RUN mkdir -p storage/framework/cache
RUN mkdir -p storage/logs
RUN chmod 777 storage/logs
RUN chmod 777 -R storage/ bootstrap/

# 디렉토리 내용을 컨테이너(in docker)저장하지 않고 호스트에 저장 하도록 설정
#VOLUME ["/data", "/etc/nginx/conf.d", "/var/log/nginx"]

# nodejs package 설치
RUN npm install

# 분기 추가 composer package 설치 및 vue build dev or prd
RUN if [ "$ENV_SERVER" = "prd" ] ;\
    then\
        echo production build!!!!!!;\
        composer install --optimize-autoloader;\
        npm run production;\
    else\
        echo develop build!!!!!!;\
        composer install;\
        npm run dev;\
        composer dump-autoload;\
    fi

RUN php artisan route:clear
RUN php artisan cache:clear

RUN php artisan route:cache
RUN php artisan config:cache

WORKDIR /var/www/html

# 캐시 클리어
RUN yum clean all

#명령어 실행
CMD ["supervisord", "-n", "-c", "/etc/supervisord.d/supervisord.conf"]

# 포트 허용
EXPOSE 9000
EXPOSE 80
EXPOSE 443

