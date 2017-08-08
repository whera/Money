<?php

namespace WSW\Money\Support;

/**
 * Trait Calculation
 *
 * @package WSW\Money\Support
 * @author Ronaldo Matos Rodrigues <ronaldo@whera.com.br>
 */
trait Calculation
{
    /**
     * @param string|float|int $amount
     * @param string|float|int $addend
     * @param int $decimals
     *
     * @return string
     */
    protected function sum($amount, $addend, $decimals)
    {
        return bcadd($amount, $addend, $decimals);
    }

    /**
     * @param string|float|int $amount
     * @param string|float|int $subtrahend
     * @param int $decimals
     *
     * @return string
     */
    protected function subtract($amount, $subtrahend, $decimals)
    {
        return bcsub($amount, $subtrahend, $decimals);
    }

    /**
     * @param string|float|int $amount
     * @param string|float|int $other
     * @param int $decimals
     *
     * @return int
     */
    protected function comparator($amount, $other, $decimals)
    {
        return (int) bccomp($amount, $other, $decimals);
    }
}
