* Primeiro de um `cp .env.example .env`
Dentro de .env você tera que declarar seu banco de dados e o login para logar.

Depois disso será necessário executar alguns comandos, segue a ordem dos mesmos:
* `composer install`
* `php artisan key:generate`
* `php artisan migrate`
* `php artisan passport:install`