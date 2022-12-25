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
        Schema::table('languages_to_resume', function (Blueprint $table) {
            $table->foreign(['resume_id'], 'fk-language_resume_id2')->references(['id'])->on('resume')->onDelete('CASCADE');
            $table->foreign(['language_id'], 'fk-language_resume_id1')->references(['id'])->on('languages')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages_to_resume', function (Blueprint $table) {
            $table->dropForeign('fk-language_resume_id2');
            $table->dropForeign('fk-language_resume_id1');
        });
    }
};
