<?php

namespace WSW\Money;

use InvalidArgumentException;

/**
 * Class Currency
 *
 * @package WSW\Money
 * @author Ronaldo Matos Rodrigues <ronaldo@whera.com.br>
 */
final class Currency
{
    /**
     * @var string
     */
    private $code;

    /**
     * @param string $code
     */
    public function __construct($code)
    {
        if (!is_string($code)) {
            throw new InvalidArgumentException('Currency code should be string');
        }

        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param Currency $other
     *
     * @return bool
     */
    public function equals(Currency $other)
    {
        return ($this->getCode() === $other->getCode());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCode();
    }
}
