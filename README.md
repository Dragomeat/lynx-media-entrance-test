# lynxmedia-intrance-test
 
## Установка

`git clone --recursive -j8 git@github.com:Dragomeat/lynx-media-entrance-test.git`
 
1. `cp .env.example .env`
2. `cp .env.laradock.example ./laradock/.env`
3. `cd laradock`
4. `docker-compose build workspace nginx php-fpm php-worker mysql`
5. `docker-compose up -d workspace nginx php-fpm php-worker mysql`
6. `docker-compose exec --user=laradock workspace bash`
7. `composer install`
8. `art key:generate`
9. `art migrate`
10. `art proxies:sync`
11. http://localhost
