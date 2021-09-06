## Installation
```
composer create-project laravel/laravel example-app
composer require laravel/ui
php artisan ui vue --auth
```
## Most common artisans 
```
php artisan make:model Category -mf
php artisan make:model Article -mcr
php artisan  make:seeder CategoryTableSeeder
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
```

## enable controller route by route service for laravel 8
```
RouteServiceProvider.php
 protected $namespace = 'App\\Http\\Controllers';
```
