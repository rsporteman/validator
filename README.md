# rsporteman/validator

## Introduction

Code for cpf and a cnpj validator, use like zendframework 2 and 3 validators. 

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
$isValidCpf = $validatorCpf->isValid($cpf); //output: true


$post['cnpj'] = '1364679'; //it is invalid
$validatorCnpj = new Cnpj();
$isValidCnpj = $validatorCnpj->isValid($cpf); //output: false

//Get Error messages

//return array empty because cpf is valid
$errorCnpjMsg = $validatorCpf->getMessages(); //output: []

//return array with errors messages because cnpj is invalid
$errorCpfMsg = $validatorCnpj->getMessages();//output: []

?>
```
