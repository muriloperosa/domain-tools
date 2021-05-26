# Domain Tools

[![Latest Stable Version](https://poser.pugx.org/murilo-perosa/domain-tools/v)](//packagist.org/packages/murilo-perosa/domain-tools) [![Total Downloads](https://poser.pugx.org/murilo-perosa/domain-tools/downloads)](//packagist.org/packages/murilo-perosa/domain-tools) [![License](https://poser.pugx.org/murilo-perosa/domain-tools/license)](//packagist.org/packages/murilo-perosa/domain-tools)


PHP - Simple library to deal with basic DNS situations.

- Name Conversion;
- Name Sanitization;
- Name Validation;
- Check name SSL certificate;
- Check name servers;
- Get name parts (sufix, domain, subdomain);
- Get public sufix list;
- Get and/or search for DNS records: 'A', 'AAAA', 'CNAME', 'NS', 'SOA', 'MX', 'SRV', 'TXT', 'CAA', 'NAPTR', 'PTR', 'HINFO', 'A6'.

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


/**
 * Domain records
 * @var Record
 */
public $records;
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

## Record.php

Class used to handle DNS Records.


### Variables

```php

/**
 * Domain
 * @param string 
 */
public $domain;

/**
 * Allowed records to get
 * @param array
 */
private $allowed_records;

```

### Instance the class

```php
use MuriloPerosa\DomainTools\Record;
 
// instance the class
$dns = new Record('google.com');

// OR

use MuriloPerosa\DomainTools\Name;

$name = new Name('google.com');
$dns = $name->records;

```
### General functions

```php

// Return array with all records
$records = $dns->getAll(); 

// Return array with all NS records
$records = $dns->getNS(); 

// Return array with all A records
$records = $dns->getA(); 

// Return array with all AAAA records
$records = $dns->getAAAA(); 

// Return array with all CNAME records
$records = $dns->getCNAME(); 

// Return array with all SOA records
$records = $dns->getSOA(); 

// Return array with all MX records
$records = $dns->getMX(); 

// Return array with all SRV records
$records = $dns->getSRV(); 

// Return array with all TXT records
$records = $dns->getTXT(); 

// Return array with all CAA records
$records = $dns->getCAA();  // Not works on Windows (OS)

// Return array with all NAPTR records
$records = $dns->getNAPTR(); 

// Return array with all PTR records
$records = $dns->getPTR(); 

// Return array with all HINFO records
$records = $dns->getHINFO(); 

// Return array with all A6 records
$records = $dns->getA6();

// Dinamic record search - returns a result array
$records = $dns->search($type, $host);

// to get records of all types or hosts you can use '*'
$records = $dns->search('*', '*');

// you can use a string to specify wich type or host you want to search
$records = $dns->search('A', 'php.net');

// you can use arrays to specify wich types or hosts you want to search
$records = $dns->search(['A', 'MX'], ['php.net', 'blabla']);

// You can use a mix of approaches
// $records = $dns->search('*', '*');
// $records = $dns->search('*', 'php.net');
// $records = $dns->search('A', '*');
// $records = $dns->search(['A', 'MX'], ['php.net', 'blabla']);
// $records = $dns->search('*', ['php.net', 'blabla']);
// $records = $dns->search('A', ['php.net', 'blabla']);
// $records = $dns->search(['A', 'MX'], '*');
// $records = $dns->search(['A', 'MX'], 'php.net');
// $records = $dns->search(['A', 'MX'], ['php.net', 'blabla']);

```

## Author
Murilo Perosa  <<perosamurilo@gmail.com>><br/>
