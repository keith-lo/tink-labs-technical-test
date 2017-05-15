# Tink Labs coding test

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

API url prefix is `/api` with version number. (current version is *1.0*)

For example, if you would to list all accounts, you should call:
- {domain_hosts}/api/1.0/account

| Verb | URI                    | Action              | Params                                     |
|------|------------------------|---------------------|--------------------------------------------|
| POST | account                | Open an account     | **Required:** number **Optional:** balance |
| GET  | account/{{account_id}} | Get account details |                                            |
| GET  | account                | List accounts       |                                            |
| POST | account/{{account_id}} | Delete an account   |                                            |
| POST | transaction/deposit    | Deposit money       | **Required:** number, amount               |
| POST | transaction/withdraw   | Withdraw money      | **Required:** number, amount               |
| POST | transaction/transfer   | Transfer money      | **Required:** from, to, amount             |

## Testing

### Postman
Postman is the complete toolchain for API developers. To install postman, please reference https://www.getpostman.com/ .

**Setup `postman` testing environment**

1. Install and open `postman` application.
2. Select `Import` on left top menu.
3. Choose `Import Folder` tab and choose **postman/** folder of this repository.
4. After import success, select the environment set `Tink-Labs`. Change the variable to your own environment.

**Please check postman docs for how to use the API calls**

1. Mouse over `Tink-Labs` collection folder and click on `>` to show more options
2. Select button `View Docs`
