# data-storing-sample
The project is a simple implementation of a data storage app.
Please keep in mind that this is not a fully functional project, and may need more work.

Build and run in the detached mode
```shell
docker-compose up -d --build
```
Run composer
```shell
docker-compose exec console composer install
```

### ENV
!! ONLY FOR DEMONSTRATION PURPOSES
Create the .env.local file.

Provide the correct DSN connection string.
```dotenv
DSN_MYSQL='mysqli://user:secret@localhost/mydb'
```

### COMMAND
!! ONLY FOR DEMONSTRATION PURPOSES

Execute the user command to add or find a user.
```shell
docker-compose exec console php app.php app:user
```

### Options
!! ONLY FOR DEMONSTRATION PURPOSES
- `new` - create a new user
- `find` - find a suer by a given id

## Tests

Run
```shell
docker-compose exec console php ./vendor/bin/phpunit tests
```

## Miscellaneous
Php-cs-fixer
```shell
docker-compose exec console php vendor/bin/php-cs-fixer fix
```
Phpstan
```shell
docker-compose exec console php vendor/bin/phpstan analyse src/ --level 8
```