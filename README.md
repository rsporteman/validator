[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![codecov](https://codecov.io/gh/rsporteman/validator/branch/master/graph/badge.svg?token=1NT6RT49OK)](https://codecov.io/gh/rsporteman/validator)

# rsporteman/validator

## Introduction

Code for cpf and a cnpj validation, use like Laminas validators. 

## Installation using Composer

```bash
$  composer require rsporteman/validator
```

## Example

```php
<?php

use rsporteman\Validator\Cpf;
use rsporteman\Validator\Cnpj;

$post['cpf'] = '313.734.531/68'; // it is valid
$validatorCpf = new Cpf();
$isValidCpf = $validatorCpf->isValid($post['cpf']); //output: true


$post['cnpj'] = '1364679'; //it is invalid
$validatorCnpj = new Cnpj();
$isValidCnpj = $validatorCnpj->isValid($post['cnpj']); //output: false

//Get Error messages

//return array empty because cpf is valid
$errorCnpjMsg = $validatorCpf->getMessages(); //output: []

//return array with errors messages because cnpj is invalid
$errorCpfMsg = $validatorCnpj->getMessages();
var_dump($errorCpfMsg);// output: ['cnpjLength' => string 'The input contains an invalid amount of characters']


```

Ambience and Tests

```bash
#up docker container
docker-compose up 

#enter on container
docker exec -it rsporteman-validator bash

#install dependencies
composer install

#run tests
vendor/bin/phpunit 

#generate coverage, files will be generate inside .phpunit.cache
composer test:coverage
composer test:coverage-html 
```
