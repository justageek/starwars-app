<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class StarWarsApiService
{
    private const BASE_URL = 'https://swapi.dev/api/';

    public function httpGet(string $url): array
    {
        return Http::get($url)
            ->throw()
            ->json();
    }

    public function getFilm(int $episode): array
    {
        return $this->httpGet(self::BASE_URL . 'films/' . $episode);
    }

    public function peopleSearch(string $name): array
    {
        $url = self::BASE_URL . 'people/?search=' . $name;
        return $this->httpGet($url);
    }

    public function getShipById($ship_id): array
    {
        $url = self::BASE_URL . 'starships/' . $ship_id . '/';
        return $this->httpGet($url);
    }

    public function getShip($url): array
    {
        return $this->httpGet($url);
    }

    public function planets(): array
    {
        $planets = [];
        if ($data = $this->httpGet(self::BASE_URL. '/planets/')
        ) {
            foreach ($data['results'] as $planet) {
                $planets[] = $planet;
            }
        }
        return $planets;
    }
}