<?php

namespace MuriloPerosa\DomainTools;

use MuriloPerosa\DomainTools\Helpers\NameHelper;

/**
 * Class used to handle Domain and Subdomain names. 
 */
class Name {
    
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

    /**
     * Domain records
     * @var Record
     */
    public $records;

    /**
     * Create new instance
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->handleState($name);
    }

    /**
     * Convert domain name from IDN to UTF-8
     * @return \MuriloPerosa\DomainTools\Name
     */
    public function idnToUtf8() : Name
    {
        return $this->handleState(NameHelper::idnToUtf8($this->name));
    }

    /**
     * Convert domain name from IDN to ASCII
     * @return \MuriloPerosa\DomainTools\Name
     */
    public function idnToAscii() : Name
    {
        return $this->handleState(NameHelper::idnToAscii($this->name));
    }

    /**
     * Make a simple domain sanitization to reduce the user errors
     * @param $remove_www 
     * @return \MuriloPerosa\DomainTools\Name
     */
    public function sanitize(bool $remove_www = true) : Name
    {   
        return $this->handleState(NameHelper::sanitize($this->name, $remove_www));
    }

    /**
     * Return domain name servers
     * @return array
     */
    public function getNameServers() : array
    {
        $dns = $this->records->getNS();
        $nameservers = [];
        foreach ($dns as $current)
        {
            $nameservers[] = $current['target'];
        }

        return $nameservers;
    }
    
    /**
     * Check if name has SSL Certificate
     * @return bool
     */
    public function hasSsl() : bool
    {
        return NameHelper::hasSsl($this->name);
    }
    
    /**
     * Handle state when $name change
     * @param string $name
     * @return \MuriloPerosa\DomainTools\Name
     */
    private function handleState(string $name) : Name
    {
        if ($name != $this->name)
        {
            $this->name     = $name;
            $this->parts    = NameHelper::splitInParts($this->name);
            $this->segments = NameHelper::splitInSegments($this->name);
            $this->is_valid = NameHelper::validate($this->name);
            $this->sufix    = Sufix::getDnsSufix($this);
            $this->setVars();
            $this->records  = new Record($this->domain);
        }
        
        return $this;
    }

    /**
     * Set general vars
     */
    private function setVars() : void
    {
        $sufix  = ".".$this->sufix;
        $target = explode('.', substr($this->name, 0, -(strlen($sufix))));

        $domain = "";
        if (!empty($target))
        {
            $domain = end($target).$sufix;
        }

        $subdomain  = str_replace($domain, "", $this->name);
        if ($subdomain)
        {
            $subdomain = str_replace(".".$domain, "", $this->name);
        }

        $this->domain       = $domain;
        $this->subdomain    = !empty($subdomain) ? $subdomain : null;
        $this->subdomains   = !empty($subdomain) ? explode('.', ($subdomain)) : [];
        $this->is_subdomain = !empty($this->subdomains);
    }
}