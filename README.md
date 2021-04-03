# Domain Tools

[![Latest Stable Version](https://poser.pugx.org/murilo-perosa/domain-tools/v)](//packagist.org/packages/murilo-perosa/domain-tools) [![Total Downloads](https://poser.pugx.org/murilo-perosa/domain-tools/downloads)](//packagist.org/packages/murilo-perosa/domain-tools) [![Latest Unstable Version](https://poser.pugx.org/murilo-perosa/domain-tools/v/unstable)](//packagist.org/packages/murilo-perosa/domain-tools) [![License](https://poser.pugx.org/murilo-perosa/domain-tools/license)](//packagist.org/packages/murilo-perosa/domain-tools)


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

## Name.php

Class used to handle Domains and Subdomains names.


### Variables

```sh
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
 * Nem Domain
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

```sh
use MuriloPerosa\DomainTools\Name;
 
// instance Dns using a name
$name = new Name('google.com');
```

### Change state functions

```sh
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

```sh
// get current name servers
$name_servers = $name->getNameServers();

// check if name has ssl certificate
$has_ssl = $name->hasSSL();
```

## Sufix.php

Class used to handle names sufix. 

### General Functions

```sh

use MuriloPerosa\DomainTools\Sufix;
use MuriloPerosa\DomainTools\Name;

// get the sufix list
$list = Sufix::getSufixList();

// get name sufix
$name = new Name('google.com');
$sufix = Sufix::getDnsSufix($name);
```
## Author
Murilo Perosa  <<perosamurilo@gmail.com>><br/>
