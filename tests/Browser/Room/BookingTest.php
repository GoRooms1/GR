<?php

namespace Tests\Browser\Room;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BookingTest extends DuskTestCase
{
    
    public function testBookingSentSuccessfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Москва и МО');
        });
    }
}
