<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class StarWarsApiService
{
    /**
     * The swapi.dev api base URL.
     *
     * @var string
     */
    private const BASE_URL = 'https://swapi.dev/api/';

    /**
     * Perform a simple http GET against the swapi.dev api.
     *
     * @param $url
     *   The relative api URL to retrieve.
     *
     * @return array
     *   An array representing the returned json data.
     */
    public function httpGet(string $url): array
    {
        return Http::get($url)
            ->throw()
            ->json();
    }

    /**
     * Get the details for all films.
     *
     * @return array
     *   An array representing the film json details.
     */
    public function films(): array
    {
        return $this->httpGet(self::BASE_URL . 'films');
    }

    /**
     * Get the details for a single film from the api.
     *
     * @param int $film_id
     *   The id for the film to retrieve.
     *
     * @return array
     *   An array representing the film json details.
     */
    public function getFilm(int $film_id): array
    {
        return $this->httpGet(self::BASE_URL . 'films/' . $film_id);
    }

    /**
     * Perform a person search by person name.
     *
     * @param string $name
     *   The name for which to search.
     *
     * @return array
     *   An array representing search results.
     */
    public function peopleSearch(string $name): array
    {
        $url = self::BASE_URL . 'people/?search=' . $name;
        return $this->httpGet($url);
    }

    /**
     * Get details for a starship by the id value.
     *
     * @param int $ship_id
     *   The ship id.
     *
     * @return
     *   An array of ship detail data.
     */
    public function getShipById(int $ship_id): array
    {
        $url = self::BASE_URL . 'starships/' . $ship_id . '/';
        return $this->httpGet($url);
    }

    /**
     * Get details for a starship by its api URL.
     *
     * @param string $url
     *   The ship url.
     *
     * @return
     *   An array of ship detail data.
     */
    public function getShip($url): array
    {
        return $this->httpGet($url);
    }

    /**
     * Get informatio on all planets from the api.
     *
     * @return array
     *   An array of data results.
     */
    public function planets(): array
    {
        return $this->httpGet(self::BASE_URL. '/planets/');
    }
}