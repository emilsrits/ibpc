## **IBPC.** 

**_CURRENTLY IN DEVELOPMENT_**

Web shop for PC parts.

**Author:** @emilsrits - Emils Rits

### Made using:

  * Laravel 5.3
  * PHP	5.6.25/7.0.10
  * Apache	2.4.23
  * MySQL	5.7.14
  * Composer	1.2.3
  * Node.js	2.15.5
  * Gulp	3.9.1

### Installation

Install Composer, Node.js and make sure to add PHP to your %PATH% environment variable to be able to run `php artisan` commands.

Install the app's dependencies by running `composer install` using the terminal in the app root directory.

Create and configure .env file for your database and run `php artisan migrate` to migrate tables and triggers, run `php artisan db:seed` to seed tables.

Run `node -v` to ensure that Node.js is installed on your machine.

Pull Gulp as a global NPM package `npm install --global gulp` to mix .scss and .css with Laravel Elixir.

Install Node dependencies by running `npm install` using the terminal in the app root directory.

For image paths to work your website home/index URL should look something like **ibpc.dev/** not **localhost/ibpc-master/public/**. Of course how it works can be changed.
