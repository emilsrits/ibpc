<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        Schema::drop('roles');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
