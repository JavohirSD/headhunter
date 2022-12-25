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
        Schema::table('vacancy_views', function (Blueprint $table) {
            $table->foreign(['user_id'], 'fk_vacancy_views2')->references(['id'])->on('users');
            $table->foreign(['vacancy_id'], 'fk_vacancy_views1')->references(['id'])->on('vacancy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacancy_views', function (Blueprint $table) {
            $table->dropForeign('fk_vacancy_views2');
            $table->dropForeign('fk_vacancy_views1');
        });
    }
};
