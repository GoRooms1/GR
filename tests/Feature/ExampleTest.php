<?php

namespace Tests\Feature;

use App\Models\Room;
use App\User;
use Domain\Address\Models\Address;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Models\HotelType;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHotelGenerateSlug(): void
    {
        User::factory()->createOne();
        HotelType::factory()->createOne();
        /** @var Hotel $hotel */
        $hotel = Hotel::factory()->createOne();
        $this->assertModelExists($hotel);
    }

    public function testGenerateSeoForAddress(): void
    {
        User::factory()->createOne();
        HotelType::factory()->createOne();
        /** @var Hotel[] $hotels */
        $hotels = Hotel::factory()->count(3)->create();
        $countOldPageDescription = PageDescription::count();
        $hotels[0]->saveAddress('г Красноярск, ул Горького, д 24 кв 25');
        $hotels[0]->save();

        $countNewPageDescription = PageDescription::count();

        $this->assertNotEquals($countOldPageDescription, $countNewPageDescription);
    }

    public function testRemoveAddressAndHotelsSeo(): void
    {
        User::factory()->createOne();
        HotelType::factory()->createOne();
        /** @var Hotel[] $hotels */
        $hotels = Hotel::factory()->count(3)->create();
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
