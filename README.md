
## About Project

 This project delivers server-side application in PHP exposing RSS feeds
Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Installation

you will need composer to run this project

#### Install dependencies using composer
- composer install

#### Install node modules and compile all the assets
- npm install & npm run dev

### copy .env.example as .env
- cp .env.example .env

### Create a database and change in .env file under database section
- DB_DATABASE: <created_database_name>
        
#### Run the migration with seeders where default four categories are seeded ['health','sports','movies','politics']
- php aritsan migrate
- php artisan db:seed


## Using Project

Postman is prefered for testing Api end point

end points

1. localhost:8000/api/<category_name>
This end point will list all the articles under category

2. localhost:8000/api/<category_name>?per_page =<number_of_article_you_want>

#### accepted json format data in get request
- per_page, is_live=['true','false']

#### Request api end point will fetch data from cache for 10 minutes if request category matched.