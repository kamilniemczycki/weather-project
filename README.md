# weather-project

Recruitment task.

## Development

### 1. Create `.env` file based on `.env.example`:
```shell script
$ cp .env.example .env
```

### 2. Install backend dependencies:
```shell script
$ composer install
```

### 3. Install frontend dependencies & build static frontend files:
```
$ npm install &&
  npm run dev
```

### 4. Database migration:
Specify your database configuration in the .env file
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=weather
DB_USERNAME=root
DB_PASSWORD=
```
I recommend setting "DB_CONNECTION" to ``sqlite`` and creating the database.sqlite file in the database directory (``touch ./database/database.sqlite``).

Finally, start data migration:
```shell script
$ php artisan migrate
```

### 5. Launch the application:
```shell script
$ php artisan serv
```
**Application should be available under `127.0.0.1:8000`.**

## Commands
It is possible to start searching in with a command:
```shell script
$ php artisan get:weather {city-slug}
```
examples
```shell script
$ php artisan get:weather legnica
  City: Legnica
  Country: Poland
  Weather: Partly cloudy
  Temp: 8 °C (46 °F)

$ php artisan get:weather jelenia-gora
  City: Jelenia Gora
  Country: Poland
  Weather: Light rain shower
  Temp: 6 °C (44 °F)
```

## API
It's possible to download the current weather using the API.
`127.0.0.1:8000/api/search/jelenia-gora`
```json
{
    "city": "Jelenia Gora",
    "country": "Poland",
    "weatherDesc": "Patchy rain possible",
    "tempC": "7",
    "tempF": "44"
}
```

## Tests
Before starting the tests, create the database-test.sqlite file in the database directory (``touch ./database/database-test.sqlite``)

And run the tests with the command:

```shell script
$ php artisan test
```
