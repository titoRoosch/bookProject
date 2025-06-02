# Book Management System

A full-stack system for managing books and authors built with Laravel 10, Vue 3, Inertia.js, Pinia, and Docker.

## About the Project

This application allows users to create, view, update, and delete books and authors. It features:

- Filterable and sortable book listing
- Many-to-many relationships between books and authors
- Real-time dashboard with metrics and charts
- Full test coverage with Pest and Vitest

## Tech Stack

- **Backend:** Laravel 10, PHP 8, Pest (testing)
- **Frontend:** Vue 3, Inertia.js, Pinia, Tailwind CSS, Vite
- **Database:** PostgreSQL
- **Testing:** Pest (PHP), Vitest (Vue)
- **Containerization:** Docker, Docker Compose

## Features 

- CRUD operations for Books and Authors

- Pagination, filtering, and sorting for listings

- Many-to-many relationships (books ↔ authors)

- Dashboard with real-time metrics and charts

- Dockerized environment for easy setup and deployment

- Automated tests covering backend and frontend

## Requirements

- Docker
- Docker Compose
- npm
- nvm (optional, for Node.js version control)

---

## Setup Instructions

1. Clone this repository.

2. Copy the environment file:

    ```bash
    cp .env.example .env
    ```

3. Build the Docker containers:

    ```bash
    docker-compose build
    ```

4. Create a Docker network (if not already created):

    ```bash
    docker network create library_laravel_app_network
    ```

5. Start the Docker containers:

    ```bash
    docker-compose up -d
    ```

6. Access the application container:

    ```bash
    docker-compose exec web bash
    ```

7. Install PHP dependencies with Composer:

    ```bash
    composer install
    ```

8. Generate the Laravel application key:

    ```bash
    php artisan key:generate
    ```

9. Set proper permissions for storage:

    ```bash
    chmod -R 775 storage/
    chown -R www-data:www-data storage/
    ```

10. Clear config and cache:

    ```bash
    php artisan config:clear
    php artisan cache:clear
    ```

11. Run the database migrations:

    ```bash
    php artisan migrate
    ```

12. Exit the container:

    ```bash
    exit
    ```

13. Install and build the frontend dependencies:

    ```bash
    npm install
    npm run dev
    ```

---

## Running Tests

### Backend (PHP - Pest)

1. Access the application container:

    ```bash
    docker-compose exec web bash
    ```

2. Prepare the testing database:

    ```bash
    php artisan config:clear --env=testing
    php artisan migrate:fresh --seed --env=testing
    ```

3. Exit the container:

    ```bash
    exit
    ```

4. Run backend tests:

    ```bash
    docker-compose run --rm web vendor/bin/pest
    ```

---

 ### Frontend (Vue - Vitest)

1. Run frontend tests with:


    ```bash
    npx vitest
    ```