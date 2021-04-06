<?php

use MuriloPerosa\DomainTools\Helpers\NameHelper;
use PHPUnit\Framework\TestCase;


class NameHelperTest extends TestCase
{   
    /**
     * @test
     */
    public function sanitizeRemovesBlankSpaces()
    {
        $name = NameHelper::sanitize('goo gle . com', false);
        $this->assertEquals($name, 'google.com');
    }

    /**
     * @test
     */
    public function sanitizeConvertToLowerCase()
    {
        $name = NameHelper::sanitize('GOOGLE.COM', false);
        $this->assertEquals($name, 'google.com');
    }

    /**
     * @test
     */
    public function sanitizeRemovesHttp()
    {
        $name = NameHelper::sanitize('http://google.com', false);
        $this->assertEquals($name, 'google.com');
    }

    /**
     * @test
     */
    public function sanitizeRemovesHttps()
    {
        $name = NameHelper::sanitize('https://google.com', false);
        $this->assertEquals($name, 'google.com');
    }

    /**
     * @test
     */
    public function sanitizeRemovesWww()
    {
        $name = NameHelper::sanitize('https://www.google.com', true);
        $this->assertEquals($name, 'google.com');
    }

    /**
     * @test
     */
    public function sanitizeNotRemovesWww()
    {
        $name = NameHelper::sanitize('https://www.google.com', false);
        $this->assertEquals($name, 'www.google.com');
    }

    /**
     * @test
     */
    public function splitNameInParts()
    {
        $parts = NameHelper::splitInParts('google.com');
        $this->assertSame(['google', 'com'], $parts);
    }

    /**
     * @test
     */
    public function splitNameInSegments()
    {
        $segments = NameHelper::splitInSegments('google.com');
        $this->assertSame(['google.com', 'com'], $segments);
    }

    /**
     * @test
     */
    public function validateValidName()
    {
        $this->assertTrue(NameHelper::validate('google.com'));
    }

    /**
     * @test
     */
    public function validateNotValidName()
    {
        $this->assertFalse(NameHelper::validate('googl e.com'));
    }

    /**
     * @test
     */
    public function convertToUtf8()
    {
        $name = NameHelper::idnToUtf8('xn--tst-qla.de');
        $this->assertEquals('täst.de', $name);
    }

    /**
     * @test
     */
    public function convertToAscii()
    {
        $name = NameHelper::idnToAscii('täst.de');
        $this->assertEquals('xn--tst-qla.de', $name);
    }

    /**
     * @test
     */
    public function nameHasSsl()
    {
        $has_ssl = NameHelper::hasSsl('google.com');
        $this->assertTrue($has_ssl);
    }

    /**
     * @test
     */
    public function nameHasNotSsl()
    {
        $has_ssl = NameHelper::hasSsl('kasjdajskjlllagoofle.com');
        $this->assertFalse($has_ssl);
    }
}
