<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use Domain\Address\Models\Metro;
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
        Schema::table('metros', function (Blueprint $table) {
            $table->integer('distance')->after('distance_int');
        });

        $metros = Metro::query()->get()->map(function (Metro $m) {
            $m->distance = $m->distance_int;
            $m->save();

            return $m;
        });

        Schema::table('metros', function (Blueprint $table) {
            $table->dropColumn(['distance_int']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('metros', function (Blueprint $table) {
            $table->integer('distance_int')->after('distance');
//      $table->dropColumn('distance');
        });

        $metros = Metro::query()->get()->map(function (Metro $m) {
            $m->distance_int = $m->distance;
            $m->save();

            return $m;
        });

        Schema::table('metros', function (Blueprint $table) {
//      $table->integer('distance_int')->after('distance');
            $table->dropColumn('distance');
        });
    }
};
