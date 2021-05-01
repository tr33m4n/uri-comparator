<?php

declare(strict_types=1);

namespace tr33m4n\UrlObject;

use Closure;

/**
 * Class Comparator
 *
 * @package tr33m4n\UrlObject
 */
class Comparator
{
    /**
     * @var \tr33m4n\UrlObject\Url[]
     */
    private $urls;

    /**
     * Comparator constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * Compare multiple URLs
     *
     * @throws \tr33m4n\UrlObject\Exception\UrlException
     * @param string|\tr33m4n\UrlObject\Url ...$urls
     * @return \tr33m4n\UrlObject\Comparator
     */
    public static function compare(...$urls): Comparator
    {
        $comparator = new self();
        $comparator->urls = array_map(static function ($url) {
            return !$url instanceof Url ? Url::fromString($url) : $url;
        }, $urls);

        return $comparator;
    }

    /**
     * Check whether entire URL strings match
     *
     * @return bool
     */
    public function match(): bool
    {
        return $this->equals(static function (Url $url): string {
            return (string) $url;
        });
    }

    /**
     * Check whether all schemes match
     *
     * @return bool
     */
    public function matchScheme(): bool
    {
        return $this->equals(static function (Url $url): ?string {
            return $url->getScheme();
        });
    }

    /**
     * Check whether all users match
     *
     * @return bool
     */
    public function matchUser(): bool
    {
        return $this->equals(static function (Url $url): ?string {
            return $url->getUser();
        });
    }

    /**
     * Check whether all passwords match
     *
     * @return bool
     */
    public function matchPass(): bool
    {
        return $this->equals(static function (Url $url): ?string {
            return $url->getPass();
        });
    }

    /**
     * Check whether all hosts match
     *
     * @return bool
     */
    public function matchHost(): bool
    {
        return $this->equals(static function (Url $url): ?string {
            return $url->getHost();
        });
    }

    /**
     * Check whether all ports match
     *
     * @return bool
     */
    public function matchPort(): bool
    {
        return $this->equals(static function (Url $url): ?int {
            return $url->getPort();
        });
    }

    /**
     * Check whether all paths match
     *
     * @return bool
     */
    public function matchPath(): bool
    {
        return $this->equals(static function (Url $url): ?string {
            return $url->getPath();
        });
    }

    /**
     * Check whether all parameters match
     *
     * @return bool
     */
    public function matchParameters(): bool
    {
        return $this->equals(static function (Url $url) {
            $parameters = $url->getParameters();
            usort($parameters, static function (UrlParameter $urlParameterA, UrlParameter $urlParameterB) {
                return strcmp($urlParameterA->getKey(), $urlParameterB->getKey());
            });

            return http_build_query(
                array_reduce(
                    $parameters,
                    static function (array $parametersAsArray, UrlParameter $urlParameter): array {
                        return $parametersAsArray = array_merge(
                            $parametersAsArray,
                            [$urlParameter->getKey() => $urlParameter->getValue()]
                        );
                    },
                    []
                )
            );
        });
    }

    /**
     * Check whether all fragments match
     *
     * @return bool
     */
    public function matchFragment(): bool
    {
        return $this->equals(static function (Url $url): ?string {
            return $url->getFragment();
        });
    }

    /**
     * Compare array of values returned from passed callback
     *
     * @param \Closure $callback
     * @return bool
     */
    private function equals(Closure $callback): bool
    {
        return count(
            array_unique(
                array_map(static function (Url $url) use ($callback) {
                    return $callback($url);
                }, $this->urls)
            )
        ) === 1;
    }
}
