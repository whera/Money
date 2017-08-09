<?php

namespace WSW\Money;

use InvalidArgumentException;
use WSW\Money\Support\Calculation;
use WSW\Money\Support\Formatters;

/**
 * Class Money
 *
 * @package WSW\Money
 * @author Ronaldo Matos Rodrigues <ronaldo@whera.com.br>
 */
final class Money
{
    use Calculation;
    use Formatters;

    const SCALE = 6;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @param string $amount
     * @param Currency $currency
     */
    public function __construct($amount, Currency $currency)
    {
        $this->amount = sprintf('%0.'.static::SCALE.'f', $amount);
        $this->currency = $currency;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     *
     * @return self
     */
    public function newInstance($amount)
    {
        return new self($amount, $this->getCurrency());
    }

    /**
     * @param Money $other
     *
     * @return bool
     */
    public function equals(Money $other)
    {
        return (bool) ($this->currency->equals($other->getCurrency()) && $this->getAmount() === $other->getAmount());
    }

    /**
     * @param Money $other
     * @throws InvalidArgumentException
     *
     * @return self
     */
    private function assertSameCurrency(Money $other)
    {
        if (!$this->getCurrency()->equals($other->getCurrency())) {
            throw new InvalidArgumentException('Currencies must be identical');
        }

        return $this;
    }

    /**
     * @param Money $other
     * @throws InvalidArgumentException
     *
     * @return int
     */
    public function compare(Money $other)
    {
        $this->assertSameCurrency($other);

        return $this->comparator($this->getAmount(), $other->getAmount(), static::SCALE);
    }

    /**
     * @param Money $addend
     * @throws InvalidArgumentException
     *
     * @return Money
     */
    public function add(Money $addend)
    {
        $this->assertSameCurrency($addend);

        return $this->newInstance($this->sum($this->getAmount(), $addend->getAmount(), static::SCALE));
    }

    /**
     * @param Percentage $percentage
     *
     * @return Money
     */
    public function addPercent(Percentage $percentage)
    {
        $newValue = ($this->getAmount() * $percentage->getPercent());

        return $this->newInstance($this->sum($this->getAmount(), $newValue, static::SCALE));
    }

    /**
     * @param Money $subtrahend
     * @throws InvalidArgumentException
     *
     * @return Money
     */
    public function sub(Money $subtrahend)
    {
        $this->assertSameCurrency($subtrahend);

        return $this->newInstance($this->subtract($this->getAmount(), $subtrahend->getAmount(), static::SCALE));
    }

    /**
     * @param Percentage $percentage
     *
     * @return Money
     */
    public function subPercent(Percentage $percentage)
    {
        $newValue = ($this->getAmount() * $percentage->getPercent());

        return $this->newInstance($this->subtract($this->getAmount(), $newValue, static::SCALE));
    }

    /**
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     *
     * @return string
     */
    public function getFormat($decimals = 2, $decPoint = ',', $thousandsSep = '.')
    {
        return $this->format($this->getAmount(), $decimals, $decPoint, $thousandsSep);
    }

    /**
     * @param int $decimals
     *
     * @return string
     */
    public function getRound($decimals = 2)
    {
        return $this->round($this->getAmount(), $decimals);
    }

    /**
     * @param int $decimals
     *
     * @return string
     */
    public function getTruncate($decimals = 2)
    {
        return $this->truncate($this->getAmount(), $decimals);
    }

    /**
     * @return int
     */
    public function getMicros()
    {
        return (int) preg_replace('/[^0-9]/', '', $this->getAmount());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFormat();
    }
}
