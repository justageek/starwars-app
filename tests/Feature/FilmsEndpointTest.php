<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JsonSchema\Validator;

class FilmsEndpointTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_getting_a_film_returns_json_data()
    {
        $response = $this->get('/api/v1/films/1');

        $response->assertStatus(200);
        $validator = new Validator();
        $object = (object) ['$ref' => 'file://' . realpath(__DIR__ . '/schemas/film.json')];
        $json = json_decode($response->getContent());
        $validator->validate($json, $object);
        $this->assertTrue($validator->isValid(), "Brian");
        foreach ($validator->getErrors() as $error) {
            $this->assertFalse(true, serialize($error));
        }

        $response
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function ($data) {
                    $data->where('title', 'A New Hope')
                        ->etc();
                });
        });
    }

    public function test_that_film_data_is_cacned()
    {
        Cache::flush();
        $data = Cache::get('Film:1');
        $this->assertEmpty($data);
        $response = $this->get('/api/v1/films/1');
        $data = Cache::get('Film:1');
        $this->assertNotEmpty($data);
    }
}
