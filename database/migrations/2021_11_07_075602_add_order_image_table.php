<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 *  Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use Domain\Image\Models\Image;
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
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn(['default']);

            $table->tinyInteger('order')->nullable();
        });

        $hotels = \Domain\Hotel\Models\Hotel::withoutGlobalScope(\Domain\Hotel\Scopes\ModerationScope::class)->get();
        foreach ($hotels as $h) {
            $i = 1;
            $images = $h->images()->each(function (Image $image) use (&$i) {
                $image->order = $i;
                $image->save();

                $i++;
            });
        }

        $rooms = \Domain\Room\Models\Room::withoutGlobalScope(\Domain\Room\Scopes\RoomModerationScope::class)->get();
        foreach ($rooms as $r) {
            $i = 1;
            $images = $r->images()->each(function (Image $image) use (&$i) {
                $image->order = $i;
                $image->save();

                $i++;
            });
        }

        Image::whereNull('order')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->boolean('default')->default(0);

            $table->dropColumn(['order']);
        });
    }
};
