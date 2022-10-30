<?php

namespace Tests\Feature\Hotel;

use App\User;
use Domain\Hotel\Actions\GenerateSlugForHotel;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Models\HotelType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class SlugGeneratorTest extends TestCase
{
    use DatabaseTransactions;

    protected Hotel $hotel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->generateHotel();
    }

    public function testSlugGeneratorAction(): void
    {
        $this->assertEquals(Str::slug($this->hotel->name), GenerateSlugForHotel::run($this->hotel->getData()));
        $this->hotel->slug = GenerateSlugForHotel::run($this->hotel->getData());
        $this->hotel->save();
        $hotel2 = Hotel::withoutEvents(fn () => Hotel::factory()->createOne([
            'name' => $this->hotel->name,
        ]));

        $this->assertEquals(Str::slug($hotel2->name).'-1', GenerateSlugForHotel::run($hotel2->getData()));
    }

    protected function generateHotel(): Hotel
    {
        User::factory()->createOne();
        HotelType::factory()->createOne();

        $this->hotel = Hotel::withoutEvents(fn () => Hotel::factory()->createOne());

        return $this->hotel;
    }
}
