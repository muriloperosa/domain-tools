<?php 

namespace MuriloPerosa\DomainTools\Helpers;

/**
 * Helper functions for names
 */
class NameHelper{

    /**
     * Sanitize name
     * @param string $name
     * @param bool   $remove_www
     * @return string
     */
    public static function sanitize(string $name, bool $remove_www)
    {
        // lower case
        $name = mb_strtolower($name, 'UTF-8');

        //remove blank spaces
        $name = preg_replace("/\s+/", "", $name);

        // remove http and https
        $name = preg_replace("#^https?://#i", "", $name);

        // remove www.
        if ($remove_www)
        {
            $name = preg_replace("#^www.#i", "", $name);
        }

        return $name;
    }

    /**
     * Split name in parts
     * @param string $name
     * @return array
     */
    public static function splitInParts(string $name)
    {
        return explode('.', $name);
    }

    /**
     * Return name segments
     * @param string $name
     * @return array
     */
    public static function splitInSegments(string $name)
    {
        $segments = [];

        $parts = self::splitInParts($name);

        if(!empty($parts))
        {   
            $suf = '';
            
            $key   = array_key_last($parts);
            $last  = array_key_last($parts);
        
            do 
            {
                if ($key == $last)
                {
                    $suf = $parts[$key];
                }
                else
                {
                    $suf = $parts[$key].'.'.$suf;
                }
        
                array_push($segments, $suf);
                $key--;
            } while(array_key_exists ($key, $parts));    
        
            $segments = array_reverse($segments);
        }

        return $segments;
    }

    /**
     * Validate name
     * @param string $name
     * @return bool
     */
    public static function validateName(string $name)
    {
        return !empty(filter_var($name, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME));
    }

    /**
     * Convert domain name from IDN to UTF-8
     * @param string $name
     * @return string
     */
    public static function idnToUtf8(string $name)
    {
        return idn_to_utf8($name, 0, INTL_IDNA_VARIANT_UTS46);
    }

    /**
     * Convert domain name from IDN to ASCII
     * @param string $name
     * @return string
     */
    public static function idnToAscii(string $name)
    {
        return idn_to_ascii($name, 0, INTL_IDNA_VARIANT_UTS46);
    }

    /**
     * Check if name has SSL Certificate
     * @param string $name
     * @return bool
     */
    public static function hasSSL($name)
    {
        try 
        {
            $sanitized = self::sanitize($name, false);
            $stream = stream_context_create (array("ssl" => array("capture_peer_cert" => true)));
            $read = fopen('https://'.$sanitized, "rb", false, $stream);
            $cont = stream_context_get_params($read);
            $result  = ($cont["options"]["ssl"]["peer_certificate"]);
            return (!is_null($result));
        } 
        catch (\Exception $e) 
        {
            return false;
        }
    }
}