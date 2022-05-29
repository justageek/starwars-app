<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Services\StarWarsApiService;
use Illuminate\Support\Facades\Cache;

class StarWarsService
{
    protected string $lastError;

    public function __construct(public StarWarsApiService $api) {

    }

    protected function setLastError($msg)
    {
        $this->lastError = $msg;
        Log::error($msg);
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }

    public function getFilm($episode): array
    {
        $data =  Cache::get('Film:' . $episode);
        if (empty($data)) {
            try {
                $film = $this->api->getFilm($episode);
                Cache::put('Film:' . $episode, $film);
                return $film;
            } catch (\Exception $e) {
                $this->setLastError($e->getMessage());
            }
        } else {
            return $data;
        }
        return [];
    }

    public function getFilmSpecies($episode): array|bool
    {
        $data =  Cache::get('FilmSpecies:' . $episode);
        if (empty($data)) {
            try {
               if ($film = $this->getFilm($episode)) {
                   return $this->buildSpeciesCache($episode, $film);
               }
            } catch (\Exception $e) {
                $this->setLastError($e->getMessage());
            }
        }
        return $data;
    }

    public function getFilmSpeciesSummary(int $episode): array
    {
        $summary = [];
        if ($data = $this->getFilmSpecies($episode)) {
            foreach ($data as $species_id => $species) {
                if (!array_key_exists($species['classification'], $summary)) {
                    $summary[$species['classification']] = [];
                }
                $summary[$species['classification']][] = $species['name'];
            }
        }
        return $summary;
    }

    protected function buildSpeciesCache($episode, $film): array
    {
        $species = [];
        if (!empty($film['species'])) {
            foreach ($film['species'] as $url) {
                if ($one_species = $this->api->httpGet($url)) {
                    $url = Str::of($url);
                    $id = $url->rtrim('/')->substr(-1);
                    $species[] = $one_species;
                }
            }
        }
        Cache::put('FilmSpecies:' . $episode, $species);
        return $species;
    }

    public function peopleSearch(string $name): array
    {
        $results = $this->api->peopleSearch($name);
        if (!empty($results['results'])) {
            return reset($results['results']);
        }
        return [];
    }

    public function starshipsByPerson($name): array
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

    public function getStarship($ship_id): array
    {
        $data = Cache::get('Starship:' . $ship_id);
        if (empty($data)) {
            if ($data = $this->api->getShipById($ship_id)) {
                Cache::put('Starship:' . $ship_id, $data);
                return $data;
            }
        }
        return $data;
    }

    public function planets(): array
    {
        $data = Cache::get('Planets');
        if (empty($data)) {
            if (($data = $this->api->planets()) && !empty($data['results'])) {
                Cache::put('Planets', $data);
            }
        }
        return $data;
    }

    public function galaxyPopulation(): string
    {
        $population = 0;
        if ($planets = $this->planets()) {
            logger($planets);
            foreach ($planets as $planet) {
                $population+= (int) $planet['population'];
            }
        }
        return number_format($population);
    }
}