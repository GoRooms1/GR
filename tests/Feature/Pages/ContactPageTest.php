<?php

namespace Tests\Feature\Pages;

use Domain\Feedback\DataTransferObjects\FeedbackData;
use Domain\Feedback\Jobs\SendFeedbackMailJob;
use Domain\Page\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testPageOpenesSuccessfully(): void
    {        
        /** @var Page $page */
        $page = Page::where('slug', 'contacts')->with('image')->first();

        if (is_null($page))
            $page = Page::factory()->createOne([
                'slug' => 'contacts',
            ]);
        
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Contacts/Index')
                ->has('page.id')
                ->has('page.slug')
                ->has('page.title')             
        );
    }
    
    public function testContactPageDataSentSuccessfully(): void
    {       
        Bus::fake();
        $formData = $this->generateContactFormData();
        $response = $this->post(route('contact.store'), $formData->toArray());
        $response->assertRedirect(route('contact'));
        $response->assertSessionHasNoErrors();
        Bus::assertDispatched(SendFeedbackMailJob::class);
    }

    public function testEmailValidation(): void
    {        
        Bus::fake();
        $formData = $this->generateContactFormData();
        $formArray = $formData->toArray();
        $formArray['email'] = 'fake';
        $response = $this->post(route('contact.store'), $formArray);        
        $response->assertSessionHasErrors(['email']);
        Bus::assertNotDispatched(SendFeedbackMailJob::class);
    }

    public function testMessageValidation(): void
    {        
        Bus::fake();
        $formData = $this->generateContactFormData();
        $formArray = $formData->toArray();
        $formArray['message'] = '';
        $response = $this->post(route('contact.store'), $formArray);
        $response->assertSessionHasErrors(['message']);
        Bus::assertNotDispatched(SendFeedbackMailJob::class);
    }

    protected function generateContactFormData(): FeedbackData
    {
        return new FeedbackData(
            name: 'Test Name', email: 'email@mail.ru', phone: '+79022884400', message: 'Test message for testing'
        );
    }
}
