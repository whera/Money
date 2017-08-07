<?php

namespace WSW\Money;

use InvalidArgumentException;

/**
 * Class Money
 *
 * @package WSW\Money
 * @author Ronaldo Matos Rodrigues <ronaldo@whera.com.br>
 */
final class Money
{
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

        return (int) bccomp($this->getAmount(), $other->getAmount(), static::SCALE);
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
        $newValue = bcadd($this->getAmount(), $addend->getAmount(), static::SCALE);

        return $this->newInstance($newValue);
    }

    /**
     * @param Percentage $percentage
     *
     * @return Money
     */
    public function addPercent(Percentage $percentage)
    {
        $newValue = ($this->getAmount() * $percentage->getPercent());
        $newValue = bcadd($this->getAmount(), $newValue, static::SCALE);

        return $this->newInstance($newValue);
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
        $newValue = bcsub($this->getAmount(), $subtrahend->getAmount(), static::SCALE);

        return $this->newInstance($newValue);
    }

    /**
     * @param Percentage $percentage
     *
     * @return Money
     */
    public function subPercent(Percentage $percentage)
    {
        $newValue = ($this->getAmount() * $percentage->getPercent());
        $newValue = bcsub($this->getAmount(), $newValue, static::SCALE);

        return $this->newInstance($newValue);
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
        return number_format($this->getAmount(), $decimals, $decPoint, $thousandsSep);
    }

    /**
     * @param int $decimals
     *
     * @return string
     */
    public function getRound($decimals = 2)
    {
        return sprintf('%0.'.$decimals.'f', $this->getAmount());
    }

    /**
     * @param int $decimals
     *
     * @return string
     */
    public function getTruncate($decimals = 2)
    {
        if (($p = strpos($this->getAmount(), '.')) !== false) {
            return substr($this->getAmount(), 0, $p + 1 + $decimals);
        }

        return $this->getAmount();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFormat();
    }
}
