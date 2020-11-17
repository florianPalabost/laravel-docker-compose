<?php

namespace Tests\Unit;

use App\Jobs\ImportAnime;
use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportAnimeTest extends TestCase
{
    const ANIME_ID = 1;

    public function testEnvLinkIsSetAndWork()
    {
        // Given
        $this->assertNotNull(env('API_LINK'));
        $uri = env('API_LINK') . self::ANIME_ID;
        $client = new Client();

        // When
        $promise = $client->getAsync($uri);
        $response = $promise->wait();

        // Then
        $this->assertEquals('200', $response->getStatusCode());
    }
}
