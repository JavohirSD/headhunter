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
        Schema::create('positions_to_resume', function (Blueprint $table) {

            $table->integer('id', true);
            $table->integer('resume_id')->index('fk-positions_to_resume1');
            $table->integer('position_id')->index('fk-positions_to_resume2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions_to_resume');
    }
};
