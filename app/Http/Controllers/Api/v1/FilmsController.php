<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\StarWarsService;
use App\Http\Controllers\Controller;

class FilmsController extends Controller
{

    /**
     * Constructor
     *
     * @param StarWarsService $starWars
     *   An instance of the StarWarsService.
     */
    public function __construct(public StarWarsService $starWars) {

    }

    /**
     * Get a film by its api id.
     *
     * @return string
     *   JSON data results.
     */
    public function films(): array
    {
        return $this->formatResults(
            $this->starWars->films()
        );
    }

    /**
     * Get a film by its api id.
     *
     * @param int $film_id
     *   The film ID.
     *
     * @return string
     *   JSON data results.
     */
    public function getFilm(int $film_id): array
    {
        dd($this->starWars->getFilm($film_id));
        return $this->formatResults(
            $this->starWars->getFilm($film_id)
        );
    }

    /**
     * Get a film's species by the film api id.
     *
     * @param int $film_id
     *   The film ID.
     *
     * @return string
     *   JSON data results.
     */
    public function getFilmSpecies(int $film_id): array
    {
        return $this->formatResults(
            $this->starWars->getFilmSpecies($film_id)
        );
    }

    /**
     * Get a film's species summary by the film api id.
     *
     * @param int $film_id
     *   The film ID.
     *
     * @return string
     *   JSON data results.
     */
    public function getFilmSpeciesSummary(int $episode)
    {
        return $this->formatResults(
            $this->starWars->getFilmSpeciesSummary($episode)
        );
    }

    /**
     * Search for person data by person name.
     *
     * @param string $name
     *   The person's name used for the search.
     *
     * @return string
     *   JSON data results.
     */
    public function peopleSearch(string $name)
    {
        return $this->formatResults(
            $this->starWars->peopleSearch($name)
        );
    }

    /**
     * Get details for starship data by person name.
     *
     * @param string $name
     *   The person's name used for the search.
     *
     * @return string
     *   JSON data results.
     */
    public function starshipsByPerson(string $name)
    {
        return $this->formatResults(
            $this->starWars->starshipsByPerson($name)
        );
    }

    /**
     * Get the galaxy population.
     *
     * @return string
     *   JSON data results.
     */
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

    public function planets()
    {
        return $this->formatResults($this->starWars->planets());
    }
}
