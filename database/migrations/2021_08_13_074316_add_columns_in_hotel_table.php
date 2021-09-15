<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use App\Models\Hotel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInHotelTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::table('hotels', function (Blueprint $table) {
//      Второй номер телефона для заказрв
      $table->string('phone_2')->nullable()->after('phone');
//      Удаление лишней колонки
      $table->dropColumn('about');
//      Либо каждая комната отдельно, либо отели по типу и с выбором кол-ва продаж. (rooms, categories)
      $table->string('type_fond')->default(Hotel::ROOMS_TYPE)->after('phone_2');
//      Заголовок Как добраться
      $table->string('route_title', 255)->default('Как добраться')->after('route');
//      На модерации
      $table->boolean('moderate')->default(true)->after('route');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('hotels', function (Blueprint $table) {
      $table->dropColumn(['phone_2', 'type_fond', 'moderate']);
      $table->dropColumn('route_title');
      $table->text('about')->nullable();
    });
  }
}
