[![Coverage Status](https://coveralls.io/repos/github/ptsilva/sorting-service-stormtech/badge.svg?branch=master)](https://coveralls.io/github/ptsilva/sorting-service-stormtech?branch=master)
[![Build Status](https://travis-ci.org/ptsilva/sorting-service-stormtech.svg?branch=master)](https://travis-ci.org/ptsilva/sorting-service-stormtech)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ptsilva/sorting-service-stormtech/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ptsilva/sorting-service-stormtech/?branch=master)
# A Simple REST Sorting Service - StormTech
Provides REST based service to sort object in PHP
## Endpoint
### POST /sort

### Strategy Parameter example
  - /sort?strategy[title]=asc&strategy[editionYear]=desc&strategy[author]=asc
  - Body request should have the objects to sort
  - if query string is not provided, will load config env ```.env``` at ```DEFAULT_STRATEGY=title,asc,author,asc```
  
#### Request
  - [x] Content-Type **application/xml**
  - [x] Content-Type **application/json**
  
#### Response
  - [x] Accept **application/xml**
  - [x] Accept **application/json**


## Installation
Clone
```
git clone https://github.com/ptsilva/sorting-service-stormtech.git
cd sorting-service-stormtech
```
Composer
```
php composer.phar up
```
Start built-in server
```
php -S localhost:8000 -t public
```
### Postman Collection
  - To check web service functionality
  - [Public Link collection](https://www.getpostman.com/collections/d021a4493394c05271b5).
  
## Run Technical Assessment Scenarios tests
```
vendor/bin/phpunit --group=scenarios
```
## Run all tests
```
vendor/bin/phpunit
```
## Tests report
Open in your browser
```
build/coverage-html/index.html
```
## Important notes
 See main files
 
| File/Folder | Description |
| ------ | ----------- |
| ```app/Providers/AppServiceProvider.php```   | Dependency Injection. |
| ```app/Http/Controllers/SortController.php```   | Thin HTTP Layer. |
| ```app/Http/ServiceLayer/SortService.php``` | Thin Service Layer. |
| ```app/Service```    | main source, may be distributed without the REST service . |
| ```tests```    | tests folder . |

## Code Style Fixer
Run
````
vendor/bin/php-cs-fixer fix
```
 
Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).
