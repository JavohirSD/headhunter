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
        Schema::create('skills_to_resume', function (Blueprint $table) {

            $table->integer('id', true);
            $table->integer('skill_id')->index('idx-skills_to_resume1');
            $table->integer('resume_id')->index('idx-skills_to_resume2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills_to_resume');
    }
};
