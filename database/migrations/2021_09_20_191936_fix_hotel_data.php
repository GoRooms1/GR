<?php

use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
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
