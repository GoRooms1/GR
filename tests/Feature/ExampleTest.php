<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\PageDescription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHotelGenerateSlug(): void
    {
        $hotel = Factory::factoryForModel(Hotel::class)->create();
        $this->assertModelExists($hotel);
    }

    public function testGenerateSeoForAddress(): void
    {
      $hotel = Hotel::orderBy('id', 'asc')->first();
      $countOldPageDescription = PageDescription::count();
      $hotel->saveAddress('г Красноярск, ул Горького, д 24 кв 25');
      $hotel->save();

      $countNewPageDescription = PageDescription::count();

      $this->assertNotEquals($countOldPageDescription, $countNewPageDescription);
    }
}
