<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->date('birthday');
            $table->string('telephone', 24);
            $table->string('address');
            $table->string('credit_card', 18);
            $table->string('franchise');
            $table->string('email');
            $table->timestamps();
            $table->unique(['user_id', 'telephone']);
            $table->unique(['user_id', 'credit_card']);
            $table->unique(['user_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
