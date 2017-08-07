<?php

namespace WSW\Money;

class PercentageTest extends TestCase
{
    public function testInstance()
    {
        $percent = new Percentage("50%");
        $this->assertInstanceOf(Percentage::class, $percent);
    }

    public function testReturn()
    {
        $percent = new Percentage("50%");
        $this->assertEquals(0.5, $percent->getPercent());
        $this->assertEquals("50%", (string) $percent);
    }

    public function testAddPercent()
    {
        $p1 = new Percentage("50");
        $p2 = new Percentage("40");
        $result = $p1->add($p2);

        $this->assertEquals(0.9, $result->getPercent());
        $this->assertEquals("90%", (string)$result);
    }

    public function testSubPercent()
    {
        $p1 = new Percentage("49.5");
        $p2 = new Percentage("39.5");
        $result = $p1->sub($p2);

        $this->assertEquals(0.1, $result->getPercent());
        $this->assertEquals("10%", (string)$result);
    }

    public function testEquals()
    {
        $p1 = new Percentage("49.5");
        $p2 = new Percentage("39.5");
        $this->assertFalse($p1->equals($p2));

        $p3 = new Percentage("49.55");
        $p4 = new Percentage("49.55");
        $this->assertTrue($p3->equals($p4));
    }
}
