<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

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
        Schema::create('attribute_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        \Domain\Attribute\Model\AttributeCategory::create(['name' => 'Удобства']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_categories');
    }
};
