<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name', 25);
            $table->string('surname', 25);
            $table->string('email', 30)->unique();
            $table->string('phone', 25)->nullable();
            $table->string('country', 25)->nullable();
            $table->string('city', 25)->nullable();
            $table->string('address', 50)->nullable();
            $table->string('postcode', 25)->nullable();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
