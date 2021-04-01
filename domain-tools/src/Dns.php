<?php

namespace MuriloPerosa\DomainTools;

/**
 * Class to handle dns
 */
class Dns {
    
    /**
     * Domain name
     * @var string
     */
    public $name;

    /**
     * Domain sufix
     * @var string
     */
    public $sufix;

    /**
     * Domain sufix
     * @var boolean
     */
    public $is_subdomain;

    /**
     * Domain
     * @var string
     */
    public $domain;

    /**
     * Parts of name 
     * @var array
     */
    public $parts;

    /**
     * Create new instance
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;

        $this->sufix = null;
        $this->is_subdomain = null;
        $this->domain = null;
        $this->parts = $this->splitInParts();
    }

    /**
     * Convert domain name from IDN to UTF-8
     * @return \MuriloPerosa\DomainTools\Dns
     */
    public function idnToUtf8()
    {
        $name = idn_to_utf8($this->name, 0, INTL_IDNA_VARIANT_UTS46);
        return $this->handleState($name);
    }

    /**
     * Convert domain name from IDN to ASCII
     * @return \MuriloPerosa\DomainTools\Dns
     */
    public function idnToAscii()
    {
        $name = idn_to_ascii($this->name, 0, INTL_IDNA_VARIANT_UTS46);
        return $this->handleState($name);
    }

    /**
     * Split domain in parts 
     * @return array
     */
    private function splitInParts()
    {
        return explode('.', $this->name);
    }

    /**
     * Handle state when $name change
     * @param string $name
     * @return \MuriloPerosa\DomainTools\Dns
     */
    private function handleState(string $name)
    {
        if ($name != $this->name)
        {
            return new self($name);
        }
        
        return $this;
    }

    /**
     * Make a simple domain sanitization to reduce the user errors
     * @param  string $domain
     * @return \MuriloPerosa\DomainTools\Dns
     */
    public function sanitize()
    {   
        // lower case
        $name = mb_strtolower($this->name, 'UTF-8');
        
        //remove blank spaces
        $name = preg_replace("/\s+/", "", $name);

        // remove http and https
        $name = preg_replace("#^https?://#i", "", $name);

        // remove www.
        $name = preg_replace("#^www.#i", "", $name);

        return $this->handleState($name);
    }
}