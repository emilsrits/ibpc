## **IBPC.** 

**_CURRENTLY IN DEVELOPMENT_**

Online store for PC parts.

**Author:** @emilsrits - Emils Rits

### Tools:

  * Laravel     5.5
  * PHP         7.0.10
  * MySQL       5.7.14
  * jQuery      3.1.1

### Installation

Install Composer, Node.js and make sure to add PHP to your %PATH% environment variable to be able to run `php artisan` commands.

Install the app's dependencies by running `composer install` using the terminal in the app root directory.

Create and configure .env file for your database, run `php artisan key:generate` to generate APP_KEY value in .env file. 

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

Run `node -v` to ensure that Node.js is installed on your machine.

Pull Gulp as a global NPM package `npm install --global gulp` to mix .scss and .css with Laravel Elixir.

Install Node dependencies by running `npm install` using the terminal in the app root directory.

Run command `php artisan storage:link` to create symlink from `storage/app/public` to `public/storage` folder. This is needed for product images.
