<?php

use MuriloPerosa\DomainTools\Name;
use PHPUnit\Framework\TestCase;


class NameTest extends TestCase
{   
    /**
     * @test
     */
    public function canInstanceWithName(){
        $name = new Name('google.com');
        $this->assertInstanceOf(Name::class, $name);
    }
    
    /**
     * @test
     */
    public function setCorrectDomain(){
        $name_1 = new Name('google.com');
        $this->assertEquals('google.com', $name_1->domain);

        $name_2 = new Name('abc.google.com');
        $this->assertEquals('google.com', $name_2->domain);

        $name_3 = new Name('abc.def.google.com');
        $this->assertEquals('google.com', $name_3->domain);
    }

    /**
     * @test
     */
    public function setCorrectSubdomain(){
        $name_1 = new Name('google.com');
        $this->assertEquals('', $name_1->subdomain);
        $this->assertSame([], $name_1->subdomains);

        $name_2 = new Name('abc.google.com');
        $this->assertEquals('abc', $name_2->subdomain);
        $this->assertSame(['abc'], $name_2->subdomains);

        $name_3 = new Name('abc.def.google.com');
        $this->assertEquals('abc.def', $name_3->subdomain);
        $this->assertSame(['abc','def'], $name_3->subdomains);

    }
}
