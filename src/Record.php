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
    private $allowed_records;

    public function __construct($domain)
    {
        $this->domain = $domain;
        $this->allowed_records = [
            'A', 
            'AAAA',
            'CNAME', 
            'NS',
            'SOA',
            'MX',
            'SRV',
            'TXT',
            'CAA',
            'NAPTR',
            'PTR',
            'HINFO',
            'A6'
        ];
    } 

    /**
     * Return all records
     * @return array
     */
    public function getAll() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_ANY));
    }

    public function getNS() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_NS));
    }

    public function getA() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_A));
    }

    public function getAAAA() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_AAAA));
    }

    public function getCNAME() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_CNAME));
    }

    public function getSOA() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_SOA));
    }

    public function getMX() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_MX));
    }

    public function getSRV() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_SRV));
    }
    
    public function getTXT() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_TXT));
    }

    public function getCAA() : array
    {
        return !in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows']) ? $this->handleReturn(dns_get_record($this->domain, DNS_CAA)) : [];
    }

    public function getNAPTR() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_NAPTR));
    }

    public function getPTR() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_PTR));
    }

    public function getHINFO() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_HINFO));
    }

    public function getA6() : array
    {
        return $this->handleReturn(dns_get_record($this->domain, DNS_A6));
    }

    private function handleReturn($data = []) : array 
    {
        return is_array($data) ? $data: [];
    }
}