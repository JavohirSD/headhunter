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
        Schema::create('vacancy_views', function (Blueprint $table) {

            $table->integer('id', true);
            $table->integer('vacancy_id')->nullable();
            $table->integer('user_id')->nullable()->index('fk_vacancy_views2');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->unique(['vacancy_id', 'user_id'], 'idx_unique_views');
            $table->unique(['vacancy_id', 'user_id'], 'idx_unique_clicks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy_views');
    }
};
