<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsInRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('order')
              ->nullable()
              ->after('name');
            $table->integer('number')
              ->nullable()
              ->after('name');
            $table->foreignId('category_id')
              ->nullable()
              ->after('order')
              ->constrained()
              ->onUpdate('cascade')
              ->onDelete('SET NULL');
            $table->string('name_temp')
              ->nullable();
        });

        Room::query()->get()->map(function (Room $room) {
            $room->name_temp = $room->name;
            $room->save();

            return $room;
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        Room::query()->get()->map(function (Room $room) {
            $room->name = $room->name_temp;
            $room->save();

            return $room;
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['name_temp']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['order', 'category_id']);
        });
    }
}
