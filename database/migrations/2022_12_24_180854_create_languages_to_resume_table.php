<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages_to_resume', function (Blueprint $table) {

            $table->integer('id', true);
            $table->integer('language_id')->index('idx-languages_to_resume2');
            $table->integer('resume_id')->index('idx-languages_to_resume1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages_to_resume');
    }
};
