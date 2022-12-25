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
        Schema::table('portfolio_to_resume', function (Blueprint $table) {
            $table->foreign(['resume_id'], 'fk-portfolio_to_resume-resume_id')->references(['id'])->on('resume')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portfolio_to_resume', function (Blueprint $table) {
            $table->dropForeign('fk-portfolio_to_resume-resume_id');
        });
    }
};
