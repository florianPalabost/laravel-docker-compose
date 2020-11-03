<?php

namespace Tests\Unit;

use App\Jobs\ImportAnime;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnimesControllerTest extends TestCase
{
    public function testRouteImportAddJobs() {
        // Given
        Queue::fake();

        // When
        $response = $this->get('/animes/import/all');

        // Then
        $this->assertEquals(200, $response->status());
        Queue::assertPushed(ImportAnime::class, 3);
    }

}
