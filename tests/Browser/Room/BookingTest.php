<?php

namespace Tests\Browser\Room;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BookingTest extends DuskTestCase
{
    use DatabaseTransactions; 
    public function testBookingSentSuccessfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('custom.lowcost')
                ->waitFor('.booking-open')
                ->click('.booking-open')
                ->assertSee('Бронирование')
                ->type('#booking-client_fio', 'Тест Тест Тест')
                ->typeSlowly('#booking-client_phone', '77777777777')
                ->type('#booking-book_comment', 'Тестовый комментарий '.Carbon::now())                
                ->assertButtonEnabled('#booking-submit')
                ->click('#booking-submit')
                ->waitFor('#booking-success_msg', 5)
                ->assertSee('Вы отправили заявку в');
        });
    }
}
