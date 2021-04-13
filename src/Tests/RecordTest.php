<?php

use MuriloPerosa\DomainTools\Record;
use PHPUnit\Framework\TestCase;


class RecordTest extends TestCase
{   

    /**
     * @test
     */
    public function canInstanceWithName()
    {
        $record = new Record('google.com');
        $this->assertInstanceOf(Record::class, $record);
    }

    /**
     * @test
     */
    public function getAllReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getAll()));
    }

    /**
     * @test
     */
    public function getNSReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getNS()));
    }
 
    /**
     * @test
     */
    public function getAReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getA()));
    }

    /**
     * @test
     */
    public function getAAAAReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getAAAA()));
    }

    /**
     * @test
     */
    public function getCNAMEReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getCNAME()));
    }

    /**
     * @test
     */
    public function getSOAReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getSOA()));
    }

    /**
     * @test
     */
    public function getMXReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getMX()));
    }

    /**
     * @test
     */
    public function getSRVReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getSRV()));
    }

    /**
     * @test
     */
    public function getTXTReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getTXT()));
    }

    /**
     * @test
     */
    public function getCAAReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getCAA()));
    }
 
    /**
     * @test
     */
    public function getNAPTRReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getNAPTR()));
    }
 
    /**
     * @test
     */
    public function getPTRReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getPTR()));
    }
 
    /**
     * @test
     */
    public function getHIFOReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getHINFO()));
    }

    /**
     * @test
     */
    public function getA6ReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->getA6()));
    }

    /**
     * @test
     */
    public function searchReturnsArray()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->search()));
    }

    /**
     * @test
     */
    public function searchHasDefaultParams()
    {
        $record = new Record('google.com');
        $this->assertTrue(is_array($record->search()));
    }

    /**
     * @test
     */
    public function searchAcceptStringsParams()
    {
        $record = new Record('php.net');
        $this->assertTrue(is_array($record->search('A', 'php.net')));
    }

    /**
     * @test
     */
    public function searchAcceptArraysParams()
    {
        $record = new Record('php.net');
        $this->assertTrue(is_array($record->search(['A', 'MX'], ['php.net', 'blablabla'])));
    }
}
