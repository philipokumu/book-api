## About this Book API

The application shows a basic book api application made with Laravel backend. It has no frontend but the documentation is displayed on swagger documentation tool.

## Setup

#### Clone and setup project

```
git clone https://github.com/philipokumu/book-api.git
```

1. Open project

```
cd book-api
```

2. Install dependencies

```
composer install
```

3. Create a database for the project in your php localhost e.g. pokemon-api

```
Copy .env.example to .env
```

4. Open .env file and ensure to setup DB_DATABASE, DB_USERNAME and DB_PASSWORD for your database according to your environment

5. Migrate and seed the database

```
php artisan migrate --seed
```

6. Start your server

```
php artisan serve
```

7. Access the site through the link provided by the above command. For example: http://127.0.0.1:8000
8. Access the swagger documentation and test the endpoints: http://127.0.0.1:8000/swagger/index.html

## Points of improvement in the application

-   There is no frontend setup, thus that would be a point of improvement.
-   The backend api does not have the characters endpoints created due to time limit.

## Notable features of the application

-   All endpoints are created using the Test Driven Development approach
