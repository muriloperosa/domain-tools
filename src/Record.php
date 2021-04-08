<?php

namespace MuriloPerosa\DomainTools;

use MuriloPerosa\DomainTools\Helpers\NameHelper;

/**
 * Class used to handle DNS Records
 */
class Record {

    /**
     * Domain
     * @param string 
     */
    public $domain;

    /**
     * Allowed records to get
     * @param array
     */
    private $accepted_records;

    public function __construct($domain)
    {
        $this->domain = $domain;
        $this->accepted_records = [
            'A',
            'AAAA',
            'CNAME',
            'NS',
            'SOA',
            'MX',
            'SRV',
            'TXT',
            'DNSKEY',
            'CAA',
            'NAPTR',
        ];
    } 

    /**
     * Return domain records
     * @param mixed $types
     */
    public function getRecords(...$types)
    {

    }

}