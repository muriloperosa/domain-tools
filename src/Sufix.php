<?php

namespace MuriloPerosa\DomainTools;

use MuriloPerosa\DomainTools\Traits\HasFile;

/**
 * Class used to handle names sufix. 
 */
class Sufix {
    
    use HasFile;
    
    static $data_path = __DIR__ .'/../data/public-sufix-list.dat';

    /**
     * Sufix list
     * @var array
     */
    static $list;

    /**
     * Returns the sufix list
     * @return array
     */
    public static function getSufixList()
    {
        if (empty(self::$list))
        {
            self::populateSufixList();
        }

        return self::$list;
    }

    /**
     * Return domain sufix
     * @return string
     */
    public static function getDnsSufix(Name $dns)
    {
        foreach ($dns->segments as $segment) 
        {
            if (in_array($segment, self::getSufixList())) 
            {
                return $segment;
            } 
        }

        return '';
    }

    /**
     * Populate the sufix list
     */
    private static function populateSufixList()
    {
        self::$list = [];

        foreach (self::getLines(self::$data_path) as $n => $line) 
        {
            $line = preg_replace('/\s+/', ' ', trim($line));
            if (!empty($line) && strpos($line, '//') === false)
            {
                array_push(self::$list, $line);
            }
        }
    }
}