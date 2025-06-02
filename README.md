# Laravel 10 + Vue 3 + Inertia.js Book Management System

## Requirements

- Docker
- Docker-compose
- npm
- nvm (for node version controll)


## Setup Instructions

1. Clone this repository.
2. Copy the .env.example file to .env:
    ```
    cp .env.example .env
    ```
3. Build the Docker containers:
    ```
    docker-compose build
    ```
4. Create a Docker network for the application:
    ```
    docker network create library_laravel_app_network
    ```
5. Start the Docker containers:
    ```
    docker-compose up -d
    ```
6. Access the application container:
    ```
    docker-compose exec web bash
    ```
7. Install Composer dependencies:
    ```
    composer install
    ```
8. Generate the application key:
    ```
    php artisan key:generate
    ```
9. Set the storage permissions:
    ```
    chmod -R 775 storage/
    chown -R www-data:www-data storage/
    ```
10. Clear Laravel config and cache:
    ```
    php artisan config:clear
    php artisan cache:clear
    ```
11. Run the database migrations:
    ```
    php artisan migrate
    ```
12. Exit the container:
    ```
    exit
    ```
13. Set up Vue frontend:
    ```
    npm install
    npm run dev
    ```

## Tests Instructions

1. Access the application container:
    ```
    docker-compose exec web bash
    ```

2. Run the commands
    ```
    php artisan config:clear --env=testing
    php artisan migrate --env=testing
    ```

3. Exit the container:
    ```
    exit
    ```

4. Run the tests
    ```
    docker-compose run --rm web vendor/bin/phpunit
    ```

