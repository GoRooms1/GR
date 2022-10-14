<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Hotel;
use App\Models\PageDescription;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;

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

    public function testRemoveAddressAndHotelsSeo(): void
    {
        $pgs = PageDescription::where('model_type', Hotel::class)->get();
        foreach ($pgs as $pg) {
            if (! Hotel::withoutGlobalScope('moderation')->where('id', $pg->model_id)->exists()) {
                $pg->delete();
            }
        }

        $pgs = PageDescription::where('model_type', Room::class)->delete();

        $addresses = Address::all();
        foreach ($addresses as $address) {
            $address->delete();
        }

        $hotels = Hotel::withoutGlobalScope('moderation')->get();
        foreach ($hotels as $hotel) {
            $hotel->delete();
        }

        $count = PageDescription::count();

        $this->assertEquals(0, $count);
    }
}
