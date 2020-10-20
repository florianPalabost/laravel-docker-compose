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

    public function testEnvLinkIsSetAndWork() {
        $this->assertNotNull(env('API_LINK'));
        $uri = env('API_LINK') . self::ANIME_ID;

        $client = new Client();
        $promise = $client->getAsync($uri);
        $response = $promise->wait();
        $this->assertEquals('200', $response->getStatusCode());

    }

}
