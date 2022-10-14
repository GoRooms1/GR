<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

use App\Models\Cost;
use App\Models\Period;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Новая таблица для стоимости комнат
 */
class RewriteCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('costs_old', function (Blueprint $table) {
            $table->id();
            $table->double('value')->nullable();
            $table->integer('min')->default(1);
            $table->string('count')->nullable();
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();
            $table->nullableMorphs('model');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Cost::query()->get()->map(function (Cost $cost) {
            $nCost = $cost->replicate();
            $nCost->setTable('costs_old');
            $nCost->save();
        });

        Cost::truncate();

        Schema::table('costs', function (Blueprint $table) {
            $table->dropMorphs('model');
            $table->dropForeign(['type_id']);
            $table->dropColumn(['start_at', 'end_at', 'min', 'user_id', 'count', 'description', 'type_id']);

            $table->foreignId('room_id')
              ->after('value')
              ->constrained('rooms')
              ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->foreignId('period_id')
              ->after('room_id')
              ->constrained('periods')
              ->onUpdate('cascade')
              ->onDelete('cascade');
        });

        $costs = DB::table('costs_old')->get();

        foreach ($costs as $cost) {
            if ($cost->description && $cost->value && $cost->model_type === 'App\Models\Room') {
                $w = $cost->description;
                if (0 === strpos($w, 'от')) {
                    //      от ..
                    $start = substr(explode(' ', $w)[1], 0, strpos(explode(' ', $w)[1], '-'));
                    $end = null;
                } elseif (0 === strpos($w, 'с')) {
                    //      с .. до ..
                    $end = explode(':', explode(' ', $w)[3])[0];
                    $start = explode(':', explode(' ', $w)[1])[0];
                }

                $nCost = new Cost();
                $nCost->value = $cost->value;
                $nCost->room_id = $cost->model_id;
                $period = Period::whereStartAt($start)->whereEndAt($end)->first();
                if (! $period) {
                    $period = new Period([
                        'start_at' => $start,
                        'end_at' => $end,
                        'cost_type_id' => $cost->type_id,
                    ]);
                    $period->save();
                }
                $nCost->period()->associate($period);
                $nCost->save();
            }
        }

        Schema::dropIfExists('costs_old');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['period_id']);

            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();
            $table->integer('min')->default(1);
            $table->string('count')->nullable();
            $table->nullableMorphs('model');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable();
        });
    }
}
