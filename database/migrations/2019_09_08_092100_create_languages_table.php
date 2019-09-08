<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('iso639_1', 2);
            $table->string('iso639_2', 3);
            $table->string('name');
            $table->string('nativeName');
        });

        Schema::create('country_language', function (Blueprint $table) {
            $table->bigInteger('country_id');
            $table->bigInteger('language_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
        Schema::dropIfExists('country_language');
    }
}
