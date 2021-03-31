<?php

namespace MuriloPerosa\DomainTools;

/**
 * Class to handle domain name
 */
class Domain {
    
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
     * Create new instance
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Convert domain name from IDN to UTF-8
     * @return string
     */
    public function idnToUtf8()
    {
        $this->name = idn_to_utf8($this->name, 0, INTL_IDNA_VARIANT_UTS46);
        return $this->name;
    }

    /**
     * Convert domain name from IDN to ASCII
     * @return string
     */
    public function idnToAscii()
    {
        $this->name = idn_to_ascii($this->name, 0, INTL_IDNA_VARIANT_UTS46);
        return $this->name;
    }

    /**
     * Split domain in parts 
     * @return array
     */
    public function getDomainParts()
    {
        return explode('.', $this->name);
    }

}