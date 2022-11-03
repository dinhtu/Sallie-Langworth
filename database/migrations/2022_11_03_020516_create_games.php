<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('football_matchs', function (Blueprint $table) {
            $table->id();
            $table->dateTime("match_day");
            $table->integer("country_1");
            $table->integer("country_2");
            $table->tinyInteger("result")->default(0);
            $table->tinyInteger("knockout")->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
