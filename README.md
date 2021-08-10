NFC BACKEND

1. composer update
2. cp .env.example .env   [Set up the database]
3. php artisan key:generate
4. php artisan migrate
5. composer dump-autoload
6. php artisan db:seed
7. php artisan passport:install
8. npm install
9. npm run dev