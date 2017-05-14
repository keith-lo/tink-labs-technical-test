# Simple Banking Test

This is coding test project to simulate the functionality of a basic bank account.

## Software requirement

The system is programmed in **PHP Laravel** *(version 5.4.22)*

In order to run the system, the following software are require:
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- MYSQL

For more information, please reference:
https://laravel.com/docs/5.4

## Installation

### Step 1: Download source code

Git and clone this project.
```
git clone https://github.com/keith-lo/tink-labs-technical-test.git .
```

### Step 2: Install packages

Install composer repositories
```
composer update
```

### Step 3: Setup system environment

To setup system environments, you can edit `app/config/app.php` or copy a environment file `.env` from `.env.example`.

Update database connection `DB_` to your server settings.

### Step 4: Database migration

Run the database migrations
```
php artisan migrate
```

And insert database records
```
php db:seed
```

### Step 5: Map apache `DocumentRoot`

The system document root should be map to `public` folder.

For example:
```
DocumentRoot "/home/vagrant/projects/my-app/public"
```

## API



## Testing

### Postman
Postman is the complete toolchain for API developers. To install postman, please reference https://www.getpostman.com/ .

Please check `postman` folder for a sample of preset postman testing environment.

You can simply `Import folder` and start the api testing.
