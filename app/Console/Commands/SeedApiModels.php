<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Film;
use App\Models\Planet;
use App\Models\vehicle;
use App\Models\Starship;
use App\Models\Character;
use App\Models\Species;
use Illuminate\Console\Command;
use App\Services\StarWarsService;
use App\Services\StarWarsApiService;

class SeedApiModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:api:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the api models from the Star Wars api';

    public function __construct(
        private StarWarsService $starWars,
        private StarWarsApiService $api
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($films = $this->starWars->films()) {
            if (!empty($films['results'])) {
                foreach ($films['results'] as $data) {
                    if (!$film = Film::query()->apiUrl($data['url'])->first()) {
                        $this->info('Creating film ' . $data['title']);
                        $film = new Film();
                        $film->title = $data['title'];
                        $film->episode_id = $data['episode_id'];
                        $film->opening_crawl = $data['opening_crawl'];
                        $film->director = $data['director'];
                        $film->producer = $data['producer'];
                        $film->release_date = $data['release_date'];
                        $film->api_created = new Carbon($data['created']);
                        $film->api_edited = new Carbon($data['edited']);
                        $film->api_url = $data['url'];
                        $film->save();
                    }
                    $this->createVehicles($data['vehicles'], $film);
                    $this->createCharacters($data['characters'], $film);
                    $this->createPlanets($data['planets'], $film);
                    $this->createStarships($data['starships'], $film);
                    $this->createSpecies($data['species'], $film);
                }
            }
        }

        return Command::SUCCESS;
    }

    private function createCharacters($rows, $film)
    {
        foreach ($rows as $url)
        {
            if ($data = $this->starWars->getApiOrCache($url)) {
                if (!$character = vehicle::query()->apiUrl($data['url'])->first()) {
                    $this->info('Creating character ' . $data['name']);
                    $character = new Character();
                    $character->name = $data['name'];
                    $character->height = $data['height'];
                    $character->mass = $data['mass'];
                    $character->hair_color = $data['hair_color'];
                    $character->skin_color = $data['skin_color'];
                    $character->eye_color = $data['eye_color'];
                    $character->birth_year = $data['birth_year'];
                    $character->gender = $data['gender'];
                    $character->homeworld_api = $data['homeworld'];
                    $character->api_created = new Carbon($data['created']);
                    $character->api_edited = new Carbon($data['edited']);
                    $character->api_url = $data['url'];
                    $character->save();
                }
                $film->characters()->attach([$character->id]);
            }
        }
    }

    private function createPlanets($rows, $film)
    {
        foreach ($rows as $url)
        {
            if ($data = $this->starWars->getApiOrCache($url)) {
                if (!$planet = Planet::query()->apiUrl($data['url'])->first()) {
                    $this->info('Creating planet ' . $data['name']);
                    $planet = new Planet();
                    $planet->name = $data['name'];
                    $planet->rotation_period = $data['rotation_period'];
                    $planet->orbital_period = $data['orbital_period'];
                    $planet->diameter = $data['diameter'];
                    $planet->climate = $data['climate'];
                    $planet->gravity = $data['gravity'];
                    $planet->terrain = $data['terrain'];
                    $planet->surface_water = $data['surface_water'];
                    $planet->population = $data['population'];
                    $planet->api_created = new Carbon($data['created']);
                    $planet->api_edited = new Carbon($data['edited']);
                    $planet->api_url = $data['url'];
                    $planet->save();
                }
                $film->planets()->attach($planet);
            }
        }
    }

    private function createVehicles($rows, $film)
    {
        foreach ($rows as $url)
        {
            if ($data = $this->starWars->getApiOrCache($url)) {
                if (!$vehicle = Vehicle::query()->apiUrl($data['url'])->first()) {
                    $this->info('Creating vehicle ' . $data['name']);
                    $vehicle = new Vehicle();
                    $vehicle->name = $data['name'];
                    $vehicle->model = $data['model'];
                    $vehicle->manufacturer = $data['manufacturer'];
                    $vehicle->cost_in_credits = $data['cost_in_credits'];
                    $vehicle->length = $data['length'];
                    $vehicle->max_atmosphering_speed = $data['max_atmosphering_speed'];
                    $vehicle->crew = $data['crew'];
                    $vehicle->passengers = $data['passengers'];
                    $vehicle->cargo_capacity = $data['cargo_capacity'];
                    $vehicle->consumables = $data['consumables'];
                    $vehicle->vehicle_class = $data['vehicle_class'];
                    $vehicle->api_created = new Carbon($data['created']);
                    $vehicle->api_edited = new Carbon($data['edited']);
                    $vehicle->api_url = $data['url'];
                    $vehicle->save();
                }
                $film->vehicles()->attach($vehicle);
            }
        }
    }

    private function createStarships($rows, $film)
    {
        foreach ($rows as $url)
        {
            if ($data = $this->starWars->getApiOrCache($url)) {
                if (!$starship = Starship::query()->apiUrl($data['url'])->first()) {
                    $this->info('Creating starship ' . $data['name']);
                    $starship = new Starship();
                    $starship->name = $data['name'];
                    $starship->model = $data['model'];
                    $starship->manufacturer = $data['manufacturer'];
                    $starship->cost_in_credits = $data['cost_in_credits'];
                    $starship->length = (int) $data['length'];
                    $starship->max_atmosphering_speed = $data['max_atmosphering_speed'];
                    $starship->crew = $data['crew'];
                    $starship->passengers = $data['passengers'];
                    $starship->cargo_capacity = $data['cargo_capacity'];
                    $starship->consumables = $data['consumables'];
                    $starship->hyperdrive_rating = $data['hyperdrive_rating'];
                    $starship->mglt = $data['MGLT'];
                    $starship->starship_class = $data['starship_class'];
                    $starship->api_created = new Carbon($data['created']);
                    $starship->api_edited = new Carbon($data['edited']);
                    $starship->api_url = $data['url'];
                    $starship->save();
                }
                $film->starships()->attach($starship);
            }
        }
    }

    private function createSpecies($rows, $film)
    {
        foreach ($rows as $url)
        {
            if ($data = $this->starWars->getApiOrCache($url)) {
                if (!$species = Species::query()->apiUrl($data['url'])->first()) {
                    $this->info('Creating species ' . $data['name']);
                    $species = new Species();
                    $species->name = $data['name'];
                    $species->classification = $data['classification'];
                    $species->designation = $data['designation'];
                    $species->average_height = $data['average_height'];
                    $species->skin_colors = $data['skin_colors'];
                    $species->hair_colors = $data['hair_colors'];
                    $species->eye_colors = $data['eye_colors'];
                    $species->average_lifespan = $data['average_lifespan'];
                    $species->homeworld_url = $data['homeworld'];
                    $species->language = $data['language'];
                    $species->api_created = new Carbon($data['created']);
                    $species->api_edited = new Carbon($data['edited']);
                    $species->api_url = $data['url'];
                    $species->save();
                }
                $film->species()->attach($species);
            }
        }
    }
}
