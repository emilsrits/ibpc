# **IBPC** 

**_IN DEVELOPMENT_**

Online store in Laravel framework

**Author:** @emilsrits

## Tools

  * Laravel     5.6.39
  * PHP         >=7.1
  * MySQL       >=5.6

## Installation

1. Create and configure **.env** file for your database.

2. Install the app's dependencies by running `composer install` using the terminal in the app root directory.

3. Install Node dependencies by running `npm install` using the terminal in the app root directory.

4. Run `php artisan key:generate` to generate APP_KEY value in .env file. 

5. Add `ADMIN_EMAIL=` and `ADMIN_PASSWORD=` to your **.env** file before seeding tables. This will create admin user for you to access administrator panel.

Example:
```
ADMIN_EMAIL=admin@example.test
ADMIN_PASSWORD=admin
```

6. Run `php artisan migrate` to migrate tables and triggers, run `php artisan db:seed` to seed tables.

7. Run command `php artisan storage:link` to create symlink from `storage/app/public` to `public/storage` folder. This is needed for product images.

8. Configure mail driver for sending mail.

## Testing
### PHPUnit
Create and configure **.env.testing** file to use different database for unit/feature tests.
### Laravel Dusk
Create and configure **.env.dusk.local** file to use different database for browser tests.

