<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SitemapPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testPageOpenesSuccessfully(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);     
    }
}