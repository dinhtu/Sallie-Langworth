# go to project
# install app's dependencies
$ composer install

# install app's dependencies
$ install php >8.0
$ install node v14x
$ install npm v6x

$ cp env.example .env

# edit connect database
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=musashi
DB_USERNAME=root
DB_PASSWORD=root

### Next step

``` bash
# in your app directory
# generate laravel APP_KEY
$ php artisan key:generate

# run database migration and seed
$ php artisan migrate:refresh --seed

# generate mixing
$ npm run dev or npm run build

# and repeat generate mixing
$ npm run dev

# login with account admin@gmail.com/12345678

#check code before commit 
$ phpmd app text musashi.xml
