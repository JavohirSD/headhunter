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
        Schema::table('positions_to_resume', function (Blueprint $table) {
            $table->foreign(['position_id'], 'fk-positions_to_resume2')->references(['id'])->on('positions')->onDelete('CASCADE');
            $table->foreign(['resume_id'], 'fk-positions_to_resume1')->references(['id'])->on('resume')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('positions_to_resume', function (Blueprint $table) {
            $table->dropForeign('fk-positions_to_resume2');
            $table->dropForeign('fk-positions_to_resume1');
        });
    }
};
