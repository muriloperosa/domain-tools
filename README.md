# Domain Tools

![License](https://img.shields.io/badge/license-MIT-blue.svg) 

PHP - Simple library to deal with basic DNS situations.

- Conversion;
- Sanitization;
- Validation;
- Check SSL certificate;
- Check name servers;
- Access public sufix list;
- Get name parts (sufix, domain, subdomain).

## Package

### Installation
```sh
composer require murilo-perosa/domain-tools
```

### Updating

```sh
composer update murilo-perosa/domain-tools
```

## Basic Usage

### Dns.php

Variables:
```sh
/**
 * Domain name
 * @var string
 */
public $name;

/**
 * Domain
 * @var string
 */
public $domain;

/**
 * Domain sufix
 * @var string
 */
public $sufix;

/**
 * Name is a subdomain
 * @var boolean
 */
public $is_subdomain;

/**
 * Subdomain
 * @var string
 */
public $subdomain;

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

Instance the class:
```sh
use MuriloPerosa\DomainTools\Dns;
 
// instance Dns using a name
$dns = new Dns('google.com');
```

Change state functions: 

```sh
// convert name to UTF-8
$dns->idnToUtf8();

// convert name to ASCII
$dns->idnToAscii();

// sanitize the name
$dns->sanitize(false);

// sanitize the name and remove "www."
$dns->sanitize(true);

// you can use them like this
$dns->idnToUtf8()
    ->sanitize();
```

General functions:
```sh
// get current name servers
$name_servers = $dns->getNameServers();

// check if name has ssl certificate
$has_ssl = $dns->hasSSL();
```

### Sufix.php

General Functions:

```sh

use MuriloPerosa\DomainTools\Sufix;

// get the sufix list
$list = Sufix::getSufixList();

// get name sufix
$dns = new Dns('google.com');
$sufix = Sufix::getDnsSufix($dns);
```

## Links
- [Packagist](https://packagist.org/packages/murilo-perosa/domain-tools)

## Author
Murilo Perosa  <<perosamurilo@gmail.com>><br />
