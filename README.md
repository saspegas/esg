requirements:  
 - PHP 8.1+
  - composer v2
-------
 1. first pull project from github a folder 
 2. then create .env file for with your database credentials  `cp .env.example .env`  
 3. `composer install`  
 4. `php artisan migrate --seed`  it loads database with required data  
 5. `php  artisan  make:filament-user` to for login dashboard, enter your information such as name, mail etc.
 6. than go to `localhost/admin` url and login with your informations that just entered previous step
 7. now you can create a report for some testing.
