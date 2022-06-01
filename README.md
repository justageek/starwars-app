To install the application locally
 - Start Docker on your local machine
 - Clone the repo
 - Create a .env file using the .env.example file included
-
 - Run the following command to install and setup the Docker container:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
  ```

 - Create the following alias in your terminal, alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
 - Start the 'sail' docker environment with 'sail up', if you are unable to create the bash alias, use ./vendor/bin/sail up
 - The application runs at "localhost" after docker is running.

The repo includes a Postman collection that can be imported into Postman to demonstrate each available api call.

The api enpoints are as follows:
 - /api/v1/films/{film_id}, get the details for a film by id
 - /api/v1/films/{film_id}/species, get the species related to a specific film by film id
 - /api/v1/films/1/species-summary, get the species summary for a film by film id
 - /api/v1/people/Luke/search, search for details about a person by person's name.
 - /api/v1people/Han/starships, get starships related to a person by the person's name
 - /api/v1/galaxy-population, get the total population of the galaxy

The run the feature tests, from the root of the project run ./vendor/bin/sail test