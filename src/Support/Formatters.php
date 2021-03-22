<?php

namespace WSW\Money\Support;

/**
 * Trait Formatters
 *
 * @package WSW\Money\Support
 * @author Ronaldo Matos Rodrigues <ronaldo@whera.com.br>
 */
trait Formatters
{
    /**
     * @param string $amount
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     *
     * @return string
     */
    protected function format($amount = "0.00", $decimals = 2, $decPoint = ',', $thousandsSep = '.')
    {
        return number_format($amount, $decimals, $decPoint, $thousandsSep);
    }

    /**
     * @param string $amount
     * @param int $decimals
     *
     * @return string
     */
    protected function round($amount = "0.00", $decimals = 2)
    {
        return sprintf('%0.'.$decimals.'F', $amount);
    }

    /**
     * @param string $amount
     * @param int $decimals
     *
     * @return string
     */
    protected function truncate($amount = "0.00", $decimals = 2)
    {
        return (string) substr($amount, 0, strpos($amount, '.') + 1 + $decimals);
    }
}
