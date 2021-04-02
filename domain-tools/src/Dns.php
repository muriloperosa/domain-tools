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
     * Subdomain
     * @var string
     */
    public $subdomain;

    /**
     * Subdomains
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
     * Create new instance
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name     = $name;
        $this->parts    = $this->splitInParts();
        $this->segments = $this->splitInSegments();
        $this->is_valid = !empty(filter_var($this->name, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME));
        $this->sufix    = Sufix::getDnsSufix($this);
        $this->setVars();
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
     * Make a simple domain sanitization to reduce the user errors
     * @param $remove_www 
     * @return \MuriloPerosa\DomainTools\Dns
     */
    public function sanitize(bool $remove_www = true)
    {   
        // lower case
        $name = mb_strtolower($this->name, 'UTF-8');
        
        //remove blank spaces
        $name = preg_replace("/\s+/", "", $name);

        // remove http and https
        $name = preg_replace("#^https?://#i", "", $name);

        // remove www.
        if ($remove_www)
        {
            $name = preg_replace("#^www.#i", "", $name);
        }

        return $this->handleState($name);
    }

    /**
     * Return domain name servers
     * @return array
     */
    public function getNameServers()
    {
        $dns = dns_get_record($this->domain, DNS_NS);
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
    public function hasSSL()
    {
        try {
            $sanitized = $this->sanitize(false);
            $stream = stream_context_create (array("ssl" => array("capture_peer_cert" => true)));
            $read = fopen('https://'.$sanitized->name, "rb", false, $stream);
            $cont = stream_context_get_params($read);
            $var  = ($cont["options"]["ssl"]["peer_certificate"]);
            return (!is_null($var));
        } catch (\Exception $e) {
            return false;
        }
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
     * Return all name segments
     * @return array
     */
    private function splitInSegments()
    {
        $segments = [];

        $parts = !empty($this->parts) ? $this->parts : $this->splitInParts();

        if(!empty($parts))
        {   
            $suf = '';
            
            $key   = array_key_last($parts);
            $last  = array_key_last($parts);
        
            do{
                if($key == $last)
                {
                    $suf = $parts[$key];
                }
                else
                {
                    $suf = $parts[$key].'.'.$suf;
                }
        
                array_push($segments, $suf);
                $key--;
            }while(array_key_exists ($key, $parts));    
        
            $segments = array_reverse($segments);
        }

        return $segments;
    }

    /**
     * Set general vars
     */
    private function setVars()
    {
        $sufix  = ".".$this->sufix;
        $target = explode('.', substr($this->name, 0, -(strlen($sufix))));

        $domain = "";
        if(!empty($target))
        {
            $domain = end($target).$sufix;
        }

        $subdomain  = str_replace($domain, "", $this->name);
        if($subdomain)
        {
            $subdomain = str_replace(".".$domain, "", $this->name);
        }

        $this->domain       = $domain;
        $this->subdomain    = !empty($subdomain) ? $subdomain : null;
        $this->subdomains   = !empty($subdomain) ? explode('.', ($subdomain)) : [];
        $this->is_subdomain = !empty($subdomains);
    }
}