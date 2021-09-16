<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use App\Models\Metro;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeColorAndDistanceInMetroTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::table('metros', function (Blueprint $table) {
      $table->integer('distance_int')->after('distance');
    });

    $metros = Metro::query()->get()->map(function (Metro $m) {
      if (in_array($m->color, Metro::ARRAY_COLORS, true)) {
        $m->color = Metro::COLORS_HEX[$m->color];
      }
      $m->distance_int = explode(' ', $m->distance)[0];
      $m->save();
      return $m;
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
      $table->dropColumn(['distance_int']);
    });
  }
}
