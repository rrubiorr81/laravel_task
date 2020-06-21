### Api Task

#### Steps

Install dependencies:

````
composer install
````

Connect to DB: change `.env` to include your specific [DB_CONNECTION ,DB_HOST ,DB_PORT ,DB_DATABASE ,DB_USERNAME ,DB_PASSWORD]

Run migrations:
````
php artisan migrate
````

To serve the app using builtin php server:
````
php artisan serve
````

To seed the database with 100 users:
````
php artisan db:seed --class=UserSeeder 
```` 

Import postman collection data from file `laravel_task.postman_collection.json`. You may need to adjust the {{URL}} env variable. The token should be filled automatically on register/login.
