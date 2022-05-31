To install the application locally
 - Start Docker on your local machine
 - Clone the repo
 - Create a .env file using the .env.example file included
 - Run the following command to install and setup the Docker container:
 - ```
  docker run --rm
    -u "$(id -u):$(id -g)"
    -v $(pwd):/var/www/html
    -w /var/www/html
    laravelsail/php81-composer:latest
    composer install --ignore-platform-reqs```

 - Create a new .env file for your Laravel project using the .env.example file.
 - Create the following alias in your terminal, alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
 - Start the 'sail' docker environment with 'sail up', if you are unable to create the bash alias, use ./vendor/bin/sail up

The repo includes a Postman collection that can be imported into Postman to demonstrate each available api call.

The run the feature tests, from the root of the project run ./vendor/bin/sail test