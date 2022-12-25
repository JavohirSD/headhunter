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
        Schema::table('vacancy_clicks', function (Blueprint $table) {
            $table->foreign(['vacancy_id'], 'fk-vacancy_clicks2')->references(['id'])->on('vacancy')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'fk-vacancy_clicks1')->references(['id'])->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacancy_clicks', function (Blueprint $table) {
            $table->dropForeign('fk-vacancy_clicks2');
            $table->dropForeign('fk-vacancy_clicks1');
        });
    }
};
