<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnShowInBookingTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up ()
  {
    Schema::table('bookings', function (Blueprint $table) {
      $table->boolean('on_show')->default(false);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down ()
  {
    Schema::table('bookings', function (Blueprint $table) {
      $table->dropColumn(['on_show']);
    });
  }
}
