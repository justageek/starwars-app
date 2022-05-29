<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\StarWarsService;
use App\Http\Controllers\Controller;

class FilmsController extends Controller
{

    public function __construct(public StarWarsService $starWars) {

    }

    public function getFilm(int $episode)
    {
        return $this->formatResults(
            $this->starWars->getFilm($episode)
        );
    }

    public function getFilmSpecies(int $episode)
    {
        return $this->formatResults(
            $this->starWars->getFilmSpecies($episode)
        );
    }

    public function getFilmSpeciesSummary(int $episode)
    {
        return $this->formatResults(
            $this->starWars->getFilmSpeciesSummary($episode)
        );
    }

    public function peopleSearch(string $name)
    {
        return $this->formatResults(
            $this->starWars->peopleSearch($name)
        );
    }

    public function starshipsByPerson(string $name)
    {
        return $this->formatResults(
            $this->starWars->starshipsByPerson($name)
        );
    }

    public function galaxyPopulation()
    {
        return $this->formatResults($this->starWars->galaxyPopulation());
    }

    protected function formatResults($results)
    {
        return [
            'data' => $results,
        ];
    }
}
