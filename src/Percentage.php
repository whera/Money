<?php

namespace WSW\Money;

/**
 * Class Percentage
 *
 * @package WSW\Money
 * @author Ronaldo Matos Rodrigues <ronaldo@whera.com.br>
 */
final class Percentage
{
    const DECIMALS = 6;

    /**
     * @var float
     */
    private $percentage;

    /**
     * @param string $percentage
     */
    public function __construct($percentage)
    {
        $this->percentage = $this->convert(preg_replace("/[^0-9.]/", "", $percentage));
    }

    /**
     * @param Percentage $other
     *
     * @return bool
     */
    public function equals(Percentage $other)
    {
        return (bool) ($this->getPercent() === $other->getPercent());
    }

    /**
     * @return float
     */
    public function getPercent()
    {
        return $this->percentage;
    }

    /**
     * @param Percentage $addend
     *
     * @return Percentage
     */
    public function add(Percentage $addend)
    {
        $newValue = bcadd($this->getPercent(), $addend->getPercent(), static::DECIMALS);

        return new static($this->invert($newValue));
    }

    /**
     * @param Percentage $subtrahend
     *
     * @return Percentage
     */
    public function sub(Percentage $subtrahend)
    {
        $newValue = bcsub($this->getPercent(), $subtrahend->getPercent(), static::DECIMALS);

        return new static($this->invert($newValue));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->invert($this->percentage) . "%";
    }

    /**
     * @param string|float|int $value
     *
     * @return float
     */
    private function convert($value)
    {
        return (float) ($value / 100);
    }

    /**
     * @param float $percent
     *
     * @return string
     */
    private function invert($percent)
    {
        return ($percent * 100);
    }
}
