<?php

declare(strict_types=1);

namespace tr33m4n\UrlObject;

/**
 * Class UrlParameter
 *
 * @package tr33m4n\UrlObject
 */
class UrlParameter
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string|int|null
     */
    private $value;

    /**
     * UrlParameter constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * URL parameter from key, value
     *
     * @param string          $key
     * @param int|string|null $value
     * @return \tr33m4n\UrlObject\UrlParameter
     */
    public static function from(string $key, $value): UrlParameter
    {
        $urlParameter = new self();
        $urlParameter->key = $key;
        $urlParameter->value = $value;

        return $urlParameter;
    }

    /**
     * With value
     *
     * @param string $value
     * @return \tr33m4n\UrlObject\UrlParameter
     */
    public function withValue(string $value): UrlParameter
    {
        $urlParameter = clone $this;
        $urlParameter->value = $value;

        return $urlParameter;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Get value
     *
     * @return string|int|null
     */
    public function getValue()
    {
        return $this->value;
    }
}
