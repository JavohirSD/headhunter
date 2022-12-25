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
        Schema::create('vacancy_clicks', function (Blueprint $table) {

            $table->integer('id', true);
            $table->integer('user_id')->index('fk-vacancy_clicks1');
            $table->integer('vacancy_id')->index('fk-vacancy_clicks2');
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy_clicks');
    }
};
