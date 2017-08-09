<?php

namespace WSW\Money;

class MoneyTest extends TestCase
{
    public function testInstace()
    {
        $money = new Money("100", new Currency("BRL"));
        $this->assertInstanceOf(Money::class, $money);
    }

    public function testGetCurrency()
    {
        $money = new Money("100", new Currency("BRL"));
        $this->assertInstanceOf(Currency::class, $money->getCurrency());
    }

    public function testGetAmount()
    {
        $money = new Money("100", new Currency("BRL"));
        $this->assertEquals("100.000000", $money->getAmount());
    }

    public function testNewInstance()
    {
        $money = new Money("100", new Currency("BRL"));
        $money2 = $money->newInstance(150);

        $this->assertInstanceOf(Money::class, $money2);
        $this->assertEquals("150.000000", $money2->getAmount());
        $this->assertEquals("BRL", $money2->getCurrency()->getCode());
    }

    public function testEquals()
    {
        $money = new Money("100", new Currency("BRL"));
        $money2 = $money->newInstance(100);
        $money3 = new Money("100", new Currency("USD"));

        $this->assertTrue($money->equals($money2));
        $this->assertFalse($money->equals($money3));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currencies must be identical
     */
    public function testCompareException()
    {
        $money = new Money("100", new Currency("BRL"));
        $money3 = new Money("100", new Currency("USD"));

        $money3->compare($money);
    }

    public function testCompare()
    {
        $money = new Money("100", new Currency("USD"));
        $money2 = new Money("100", new Currency("USD"));
        $money3 = new Money("150", new Currency("USD"));

        $this->assertEquals(0, $money->compare($money2));
        $this->assertEquals(1, $money3->compare($money2));
        $this->assertEquals(-1, $money2->compare($money3));
    }

    public function testAdd()
    {
        $money = new Money("100", new Currency("USD"));
        $money2 = new Money("100", new Currency("USD"));

        $result = $money->add($money2);
        $this->assertEquals("200.000000", $result->getAmount());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currencies must be identical
     */
    public function testAddException()
    {
        $money = new Money("100", new Currency("USD"));
        $money2 = new Money("100", new Currency("BRL"));

        $result = $money->add($money2);
    }

    public function testAddPercent()
    {
        $money = new Money("100", new Currency("USD"));
        $percent = new Percentage("50");

        $result = $money->addPercent($percent);

        $this->assertEquals("150.000000", $result->getAmount());
    }

    public function testSub()
    {
        $money = new Money("100", new Currency("USD"));
        $money2 = new Money("50", new Currency("USD"));

        $result = $money->sub($money2);
        $this->assertEquals("50.000000", $result->getAmount());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currencies must be identical
     */
    public function testSubException()
    {
        $money = new Money("100", new Currency("USD"));
        $money2 = new Money("50", new Currency("BRL"));

        $money->sub($money2);
    }

    public function testSubPercent()
    {
        $money = new Money("100", new Currency("USD"));
        $percent = new Percentage("50");

        $result = $money->subPercent($percent);

        $this->assertEquals("50.000000", $result->getAmount());
    }

    public function testGetFormat()
    {
        $money = new Money("1500", new Currency("USD"));
        $this->assertEquals("1.500,00", $money->getFormat());
        $this->assertEquals("1,500.00", $money->getFormat(2, ".", ","));
        $this->assertEquals("1500.00", $money->getFormat(2, ".", ""));
        $this->assertEquals("1500.000", $money->getFormat(3, ".", ""));
    }

    public function testGetRound()
    {
        $money = new Money("1500.009999", new Currency("USD"));
        $this->assertEquals("1500.01", $money->getRound());
        $this->assertEquals("1500.010", $money->getRound(3));
    }

    public function testGetTruncate()
    {
        $money = new Money("1500.009999", new Currency("USD"));
        $this->assertEquals("1500.00", $money->getTruncate());
        $this->assertEquals("1500.009", $money->getTruncate(3));
    }

    public function testString()
    {
        $money = new Money("1500.009999", new Currency("USD"));

        $this->assertEquals("1.500,01", (string) $money);
    }

    public function testGetMicrons()
    {
        $money = new Money("1500.009999", new Currency("USD"));
        $this->assertEquals(1500009999, $money->getMicros());
    }
}
