<?php

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
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('slug')->unique()->index()->nullable();
        });

        foreach (\App\Models\Hotel::all() as &$hotel) {
            $start_slug = \Illuminate\Support\Str::slug($hotel->name);
            $slug = $start_slug;
            $try = 0;
            while (\Illuminate\Support\Facades\DB::table('hotels')->where('slug', $slug)->exists()) {
                $slug = $start_slug.'-'.$try++;
            }

            $hotel->slug = $slug;
            $hotel->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
