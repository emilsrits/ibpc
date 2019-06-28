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
ADMIN_EMAIL=admin@example.test
ADMIN_PASSWORD=admin
```

Run `php artisan migrate` to migrate tables and triggers, run `php artisan db:seed` to seed tables.

Install Node dependencies by running `npm install` using the terminal in the app root directory.

Run command `php artisan storage:link` to create symlink from `storage/app/public` to `public/storage` folder. This is needed for product images.

### Tools:

  * Laravel     5.6
  * PHP         >=7.1.3
  * MySQL       >=5.6