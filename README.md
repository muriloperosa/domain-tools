# Domain Tools

[![Latest Stable Version](https://poser.pugx.org/murilo-perosa/domain-tools/v)](//packagist.org/packages/murilo-perosa/domain-tools) [![Total Downloads](https://poser.pugx.org/murilo-perosa/domain-tools/downloads)](//packagist.org/packages/murilo-perosa/domain-tools) [![License](https://poser.pugx.org/murilo-perosa/domain-tools/license)](//packagist.org/packages/murilo-perosa/domain-tools)


PHP - Simple library to deal with basic DNS situations.

- Name Conversion;
- Name Sanitization;
- Name Validation;
- Check name SSL certificate;
- Check name servers;
- Get name parts (sufix, domain, subdomain);
- Get public sufix list.

## Install
```sh
composer require murilo-perosa/domain-tools
```

## Update

```sh
composer update murilo-perosa/domain-tools
```

## Unit Tests

To run unit tests using PHPUnit:

```sh
./vendor/bin/phpunit src/tests
```

## Lint

To run PHPLint:

```sh
./vendor/bin/phplint ./
```

## Name.php

Class used to handle Domains and Subdomains names.


### Variables

```php
/**
 * Current name
 * @var string
 */
public $name;

/**
 * Name Subdomain
 * @var string
 */
public $subdomain;

/**
 * Name Domain
 * @var string
 */
public $domain;

/**
 * Name sufix
 * @var string
 */
public $sufix;

/**
 * Name is a subdomain
 * @var boolean
 */
public $is_subdomain;

/**
 * List of Subdomains
 * @var array
 */
public $subdomains;

/**
 * Parts of name 
 * @var array
 */
public $parts;

/**
 * Segments of name 
 * @var array
 */
public $segments;

/**
 * Name is valid 
 * @var bool
 */
public $is_valid;
```

### Instance the class

```php
use MuriloPerosa\DomainTools\Name;
 
// instance the class
$name = new Name('google.com');
```

### Change state functions

```php
// convert name to UTF-8
$name->idnToUtf8();

// convert name to ASCII
$name->idnToAscii();

// sanitize the name
$name->sanitize(false);

// sanitize the name and remove "www."
$name->sanitize(true);

// you can use them like this
$name->idnToUtf8()
    ->sanitize();
```

### General functions

```php
// get current name servers
$name_servers = $name->getNameServers();

// check if name has ssl certificate
$has_ssl = $name->hasSsl();
```

## Sufix.php

Class used to handle names sufix. 

### General Functions

```php

use MuriloPerosa\DomainTools\Sufix;
use MuriloPerosa\DomainTools\Name;

// get the sufix list
$list = Sufix::getSufixList();

// get name sufix
$name = new Name('google.com');
$sufix = Sufix::getDnsSufix($name);
```

## NameHelper.php

Helper that contains static funtions for treatment situations. <br/>
You must use that class when you need to apply quick operations to the name.  

### General Functions
```php
use MuriloPerosa\DomainTools\Helpers\NameHelper;

// Sanitize name
$name = NameHelper::sanitize('https://google.com', true); // 'https://google.com' => 'google.com'

// Split name in parts
$name = NameHelper::splitInParts('google.com'); // 'google.com' => ['google', 'com']

// Return name in segment
$name = NameHelper::splitInSegments('google.com'); // 'google.com' => ['com', 'google.com']

// Validate name
$is_valid = NameHelper::validate('google.com'); // true

// Convert domain name from IDN to UTF-8
$name = NameHelper::idnToUtf8('xn--tst-qla.de'); // 'täst.de'

// Convert domain name from IDN to ASCII
$name = NameHelper::idnToASCII('täst.de'); // 'xn--tst-qla.de'

// Check if name has SSL Certificate
$has_ssl = NameHelper::hasSsl('google.com'); // true

```

## Author
Murilo Perosa  <<perosamurilo@gmail.com>><br/>
