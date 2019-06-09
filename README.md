## **IBPC** 

**_IN DEVELOPMENT_**

Online store in Laravel framework

**Author:** @emilsrits

### Installation

Install the app's dependencies by running `composer install` using the terminal in the app root directory.

Create and configure .env file for your database, run `php artisan key:generate` to generate APP_KEY value in .env file. 

Add `ADMIN_EMAIL=` and `ADMIN_PASSWORD=` to your .env file before seeding tables. This will create admin user for you to access administrator panel.
Example:
```
ADMIN_EMAIL=admin@email.invalid
ADMIN_PASSWORD=admin
```

Before running migration scripts comment out code inside AppServiceProvider.php `boot()` method. When migration script is done uncomment the code block.

```
public function boot()
{
    $parentCategories = Category::where('parent', 1)->where('status', 1)->get();
    $childCategories = Category::where('parent', 0)->where('status', 1)->get();

    View::share([
        'parentCategories' => $parentCategories,
        'childCategories' => $childCategories,
        'errors' => null
    ]);
}
```

Run `php artisan migrate` to migrate tables and triggers, run `php artisan db:seed` to seed tables.

Install Node dependencies by running `npm install` using the terminal in the app root directory.

Run command `php artisan storage:link` to create symlink from `storage/app/public` to `public/storage` folder. This is needed for product images.

### Tools:

  * Laravel     5.5
  * PHP         >=7.1.0
  * MySQL       >=5.6