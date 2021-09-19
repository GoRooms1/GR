<?php

use App\Models\Hotel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultValuePhoneInHotelTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('hotels', function (Blueprint $table) {
      $table->string('phone_old')->nullable();
    });

    Hotel::query()->get()->map(function (Hotel $hotel) {
      $hotel->phone_old = $hotel->phone;
      $hotel->save();
    });

    Schema::table('hotels', function (Blueprint $table) {
      $table->dropColumn('phone');
    });
    Schema::table('hotels', function (Blueprint $table) {
      $table->string('phone')->nullable()->after('description');
    });

    Hotel::query()->get()->map(function (Hotel $hotel) {
      $hotel->phone = $hotel->phone_old;
      $hotel->save();
    });
    Schema::table('hotels', function (Blueprint $table) {
      $table->dropColumn('phone_old');
    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('hotels', function (Blueprint $table) {
      //
    });
  }
}
