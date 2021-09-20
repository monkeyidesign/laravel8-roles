## Installation
```
composer create-project laravel/laravel example-app
composer require laravel/ui
php artisan ui vue --auth
php artisan make:model Role -m
```
## Most common artisans 
```
php artisan make:model Category -mf
php artisan make:model Article -mcr
php artisan make:controller CategoryController -r
php artisan make:seeder CategoryTableSeeder
php artisan make:middleware IsAdminMiddleware
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
php artisan make:migration add_role_id_to_users_table
```
## Register middleware
```
1- php artisan make:middleware IsAdminMiddleware
2- /app/Http/Middleware/IsAdminMiddleware.php
 public function handle($request, Closure $next)
 {
     if (!auth()->user()->is_admin) {
         abort(403);
     }

     return $next($request);
 }
3- app/Http/Kernel.php
use App\Http\Middleware\IsAdminMiddleware;
protected $routeMiddleware = [
        'is_admin' => IsAdminMiddleware::class,
        //or  'is_admin' => \App\Http\Middleware\IsAdminMiddleware::class,
    ];
```
## Sample route group
```
Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    Route::resource('articles', 'ArticleController');
    // Administrator routes
    Route::group(['middleware' => 'is_admin'], function() {
        Route::resource('categories', 'CategoryController');
    });
});
```
## Sample role
```
php artisan make:model Role -m
php artisan make:migration add_role_id_to_users_table
```
## enable controller route by route service for laravel 8
```
RouteServiceProvider.php
 protected $namespace = 'App\\Http\\Controllers';
```

## define gates
```
Providers/AuthServiceProvider
  Gate::define('publish-articles', function ($user) {
            return $user->is_admin || $user->is_publisher;
        });

1-controller
   if (Gate::allows('publish-articles')) {
        $data['published_at'] = $request->input('published') ? now() : null;
    }
2-view
   @can('publish-articles')
        <input type="checkbox" name="published" value="1" /> Published
    @endcan
```

## Policy
```
php artisan make:policy ArticlePolicy --model=Article
```

