<?php

use MuriloPerosa\DomainTools\Name;
use MuriloPerosa\DomainTools\Sufix;
use PHPUnit\Framework\TestCase;


class SufixTest extends TestCase
{   

    /**
     * @test
     */
    public function sufixListIsArray()
    {
        $this->assertTrue(is_array(Sufix::getSufixList()));
    }

    /**
     * @test
     */
    public function getCorrectSufixForname()
    {
        $this->assertEquals(Sufix::getDnsSufix(new Name('google.com')), 'com');

        $this->assertEquals(Sufix::getDnsSufix(new Name('php.net')), 'net');

        $this->assertEquals(Sufix::getDnsSufix(new Name('estado.rs.gov.br')), 'rs.gov.br');

        $this->assertEquals(Sufix::getDnsSufix(new Name('uol.com.br')), 'com.br');

        $this->assertEquals(Sufix::getDnsSufix(new Name('perosa.xyz')), 'xyz');
    }
   
}
