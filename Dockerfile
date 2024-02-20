# PHP 버전을 선택합니다. 필요에 따라 원하는 버전으로 변경할 수 있습니다.
FROM php:7.4

# 작업 디렉토리를 설정합니다. 원하는 디렉토리로 변경할 수 있습니다.
WORKDIR /var/www/html

# 호스트 파일 시스템의 소스 코드를 컨테이너의 작업 디렉토리로 복사합니다.
# 만약에 소스 코드가 다른 위치에 있다면 이 경로를 변경해야 합니다.
COPY . .

# PHP 애플리케이션에 필요한 의존성 패키지를 설치합니다.
# Composer를 사용하여 필요한 패키지를 설치할 것입니다.
# Composer 설치를 위해 필요한 패키지를 먼저 설치합니다.
RUN apt-get update && \
    apt-get install -y git zip unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install

# 컨테이너가 실행될 때 PHP 애플리케이션을 시작합니다.
CMD [ "php", "websenderapi.php" ]
