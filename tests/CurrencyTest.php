<?php

namespace WSW\Money;

class CurrencyTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(Currency::class, new Currency('BRL'));
    }

    public function testCode()
    {
        $currency = new Currency("BRL");

        $this->assertEquals('BRL', $currency->getCode());
    }

    public function testString()
    {
        $currency = new Currency('USD');

        $this->assertEquals("USD", (string) $currency);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency code should be string
     */
    public function testExceptionInstance()
    {
        $currency = new Currency(123);
    }

    public function testEqualsFalse()
    {
        $c1 = new Currency("USD");
        $c2 = new Currency("BRL");

        $this->assertFalse($c1->equals($c2));
    }

    public function testEqualsTrue()
    {
        $c1 = new Currency("BRL");
        $c2 = new Currency("BRL");

        $this->assertTrue($c1->equals($c2));
    }
}
