<?php

namespace MuriloPerosa\DomainTools;

use MuriloPerosa\DomainTools\Traits\HasDataPattern;

/**
 * Class used to handle DNS Records.
 */
class Record {

    use HasDataPattern;

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
        $this->allowed_records = ['A', 'AAAA', 'CNAME', 'NS', 'SOA', 'MX', 'SRV', 'TXT', 'CAA', 'NAPTR', 'PTR', 'HINFO', 'A6'];
    } 

    /**
     * Return array with all records
     * @return array
     */
    public function getAll() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_ANY));
    }

    /**
     * Return array with all NS records
     * @return array
     */
    public function getNS() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_NS));
    }

    /**
     * Return array with all A records
     * @return array
     */
    public function getA() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_A));
    }

    /**
     * Return array with all AAAA records
     * @return array
     */
    public function getAAAA() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_AAAA));
    }

    /**
     * Return array with all CNAME records
     * @return array
     */
    public function getCNAME() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_CNAME));
    }

    /**
     * Return array with all SOA records
     * @return array
     */
    public function getSOA() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_SOA));
    }

    /**
     * Return array with all MX records
     * @return array
     */
    public function getMX() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_MX));
    }

    /**
     * Return array with all SRV records
     * @return array
     */
    public function getSRV() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_SRV));
    }
    
    /**
     * Return array with all TXT records
     * @return array
     */
    public function getTXT() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_TXT));
    }

    /**
     * Return array with all CAA records
     * @return array
     */
    public function getCAA() : array
    {
        return !in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows']) ? $this->handleArrayReturn(dns_get_record($this->domain, DNS_CAA)) : [];
    }

    /**
     * Return array with all NAPTR records
     * @return array
     */
    public function getNAPTR() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_NAPTR));
    }

    /**
     * Return array with all PTR records
     * @return array
     */
    public function getPTR() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_PTR));
    }

    /**
     * Return array with all HINFO records
     * @return array
     */
    public function getHINFO() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_HINFO));
    }

    /**
     * Return array with all A6 records
     * @return array
     */
    public function getA6() : array
    {
        return $this->handleArrayReturn(dns_get_record($this->domain, DNS_A6));
    }

    /**
     * Dinamic record search 
     * - Return all records for specified $type(s) and $host(s)
     * @param mixed $type
     * @param mixed $host
     * @return array
     */
    public function search($type = '*', $host = '*') : array
    {
        $records = $this->searchByType($type);
        $records = $this->searchByHost($host, $records);
        return $this->handleArrayReturn($records);
    }

    /**
     * Return array of records by type
     * @param mixed $type
     * @return array
     */
    private function searchByType($type = '*') : array
    {
        $records = [];

        if ($type === '*')
        {
            $records = $this->getAll();
        }
        else
        {
            if (!is_array($type))
            {
                $type = $this->stringIntoArray($type);
            }

            foreach($type as $t)
            {
                $rt = strtoupper($t);
                if (in_array($rt, $this->allowed_records))
                {
                    $function = 'get'.$rt;
                    $records = array_merge($records, $this->$function()); // Magic here :)
                }
            }
        }


        return $this->handleArrayReturn($records);
    }

    /**
     * Return array of records by host
     * @param mixed $host
     * @param array $records
     * @return array
     */
    private function searchByHost($host, $records)
    {
       if ($host != '*')
       {
            if (!is_array($host))
            {
                $host = $this->stringIntoArray($host);
            }
            
            foreach($records as $i => $record)
            {
                if (!in_array($record['host'], $host))
                {
                    unset($records[$i]);
                }
            }
       }

       return $this->handleArrayReturn($records);
    }
}