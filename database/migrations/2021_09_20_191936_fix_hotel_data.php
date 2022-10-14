<?php

use App\Models\Hotel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Hotel::query()->get()->map(function (Hotel $hotel) {
            $hotel->show = true;
            $hotel->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
