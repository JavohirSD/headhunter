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
        Schema::table('skills_to_resume', function (Blueprint $table) {
            $table->foreign(['skill_id'], 'fk-skills_to_resume-skill_id')->references(['id'])->on('skills')->onDelete('CASCADE');
            $table->foreign(['resume_id'], 'fk-skills_to_resume-resume_id')->references(['id'])->on('resume')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skills_to_resume', function (Blueprint $table) {
            $table->dropForeign('fk-skills_to_resume-skill_id');
            $table->dropForeign('fk-skills_to_resume-resume_id');
        });
    }
};
