<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Services\StarWarsApiService;
use Illuminate\Support\Facades\Cache;

class StarWarsService
{
    protected string $lastError;

    /**
     * Constructor.
     *
     * @param StarWarsApiService $api
     *   An instance of the StarWarsApiService.
     */
    public function __construct(public StarWarsApiService $api) {

    }

    /**
     * Set the last error from use of the Star Wars API Service.
     *
     * @param string $msg
     *   The error message
     */
    protected function setLastError(string $msg): void
    {
        $this->lastError = $msg;
        Log::error($msg);
    }

    /**
     * Get the last error that occurred with an api call.
     *
     * @return string
     *   The last error message.
     */
    public function getLastError(): string
    {
        return $this->lastError;
    }

    /**
     * Get details for a specific film by film api id value.
     *
     * @param int $film_id
     *   The id of the film.
     */
    public function getFilm(int $film_id): array
    {
        $cache_key = 'Film:' . $film_id;
        $data =  Cache::get($cache_key);
        if (empty($data)) {
            try {
                $film = $this->api->getFilm($film_id);
                Cache::put($cache_key, $film);
                return $film;
            } catch (\Exception $e) {
                $this->setLastError($e->getMessage());
            }
        } else {
            return $data;
        }
        return [];
    }

    /**
     * Get details for species related to a specific film by film api id value.
     *
     * @param int $film_id
     *   The id of the film.
     *
     * @return
     *   An array of species items related to the film.
     */
    public function getFilmSpecies(int $film_id): array
    {
        $data =  Cache::get('FilmSpecies:' . $film_id);
        if (empty($data)) {
            try {
               if ($film = $this->getFilm($film_id)) {
                   return $this->buildSpeciesCache($film_id, $film);
               }
            } catch (\Exception $e) {
                $this->setLastError($e->getMessage());
            }
        }
        return $data;
    }

    /**
     * Get a summary of the species related to a specific film by film api id value.
     *
     * @param int $film_id
     *   The id of the film.
     *
     * @return
     *   An array of species classifications items related to the film.
     */
    public function getFilmSpeciesSummary(int $film_id): array
    {
        $summary = [];
        if ($data = $this->getFilmSpecies($film_id)) {
            foreach (array_values($data) as $species) {
                if (!array_key_exists($species['classification'], $summary)) {
                    $summary[$species['classification']] = [];
                }
                $summary[$species['classification']][] = $species['name'];
            }
        }
        return $summary;
    }

    /**
     * Build a cache for a film's species detail.
     *
     * @param int $film_id
     *   The id of the film.
     *
     * @return
     *   An array of species details related to the film.
     */
    protected function buildSpeciesCache(int $film_id, array $film): array
    {
        $species = [];
        if (!empty($film['species'])) {
            foreach ($film['species'] as $url) {
                if ($one_species = $this->api->httpGet($url)) {
                    $species[] = $one_species;
                }
            }
        }
        Cache::put('FilmSpecies:' . $film_id, $species);
        return $species;
    }

    /**
     * Search for person data by person name string.
     *
     * @param string $name
     *   The name used for the search.
     *
     * @return array
     *   An array of search results if found.
     */
    public function peopleSearch(string $name): array
    {
        $results = $this->api->peopleSearch($name);
        if (!empty($results['results'])) {
            return reset($results['results']);
        }
        return [];
    }

    /**
     * Search for starships related to a person data by person name string.
     *
     * @param string $name
     *   The name used for the search.
     *
     * @return array
     *   An array of starship results if found.
     */
    public function starshipsByPerson(string $name): array
    {
        $ships = [];
        if ($person = $this->peopleSearch($name)) {
            if (!empty($person['starships'])) {
                foreach ($person['starships'] as $ship_url) {
                    $url = Str::of($ship_url);
                    $url = $url->rtrim('/')->toString();
                    $parts = explode('/', $url);
                    $id = array_pop($parts);
                    if ($ship = $this->getStarship($id)) {
                        $ships[] = $ship;
                    }
                }
            }
        }
        return $ships;
    }

    /**
     * Get details for a specific starship by id value.
     */
    public function getStarship(int $ship_id): array
    {
        $cache_key = 'Starship:' . $ship_id;
        $data = Cache::get($cache_key);
        if (empty($data)) {
            if ($data = $this->api->getShipById($ship_id)) {
                Cache::put($cache_key, $data);
                return $data;
            } else {
                return [];
            }
        }
        return $data;
    }

    /**
     * Get details about all planets in the Star Wars univere.
     *
     * @return array
     *   An array of plnet items.
     */
    public function planets(): array
    {
        $planets = Cache::get('Planets');
        if (empty($planets)) {
            if (($data = $this->api->planets()) && !empty($data['results'])) {
                foreach ($data['results'] as $planet) {
                    $planets[] = $planet;
                }
                Cache::put('Planets', $planets);
            }
        }
        return $planets;
    }

    /**
     * Calculate and return the total population of the Star Wars galasy.
     *
     * @return string
     *   A formmated population total.
     */
    public function galaxyPopulation(): string
    {
        $population = 0;
        if ($planets = $this->planets()) {
            foreach ($planets as $planet) {
                $population+= (int) $planet['population'];
            }
        }
        return number_format($population);
    }
}