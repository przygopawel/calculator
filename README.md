# Instalation

```$xslt

git clone https://github.com/przygopawel/calculator.git
composer install
```

Add database configuration to .env

```$xslt
 DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```

Create database and run migration
```$xslt
 php bin/console doctrine:database:create
 
 php bin/console doctrine:migrations:migrate
```

Run application

```$xslt
php bin/console server:run
```

# Test

## Unit test

Run
```$xslt
./vendor/bin/simple-phpunit
```

# Endpoints

## Get all operations
params page and per_page are optional

```$xslt
GET /api/rest/v1/operations?page=1&per_page=25
```

## Get one operation

```$xslt
GET /api/rest/v1/operations/{id}
```

## Create operations

```$xslt
POST /api/rest/v1/operations
```
headers:

```$xslt
Content-Type: application/json
```

body:
type: operation type. Allowed type: add, subtract, multiply, divide
params: array of number

```$xslt
{
    "type": "add",
    "params": [1,2,3]
}
```