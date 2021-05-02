<?php

declare(strict_types=1);

namespace tr33m4n\UriComparator;

use Closure;
use League\Uri\Http;
use Psr\Http\Message\UriInterface;

/**
 * Class Comparator
 *
 * @package tr33m4n\UriComparator
 */
class Comparator
{
    /**
     * @var \Psr\Http\Message\UriInterface[]
     */
    private $uris;

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
     * @param string|\Psr\Http\Message\UriInterface ...$uris
     * @return \tr33m4n\UriComparator\Comparator
     */
    public static function compare(...$uris): Comparator
    {
        $comparator = new self();
        $comparator->uris = array_map(static function ($uri) {
            return !$uri instanceof UriInterface ? Http::createFromString($uri) : $uri;
        }, $uris);

        return $comparator;
    }

    /**
     * Check whether entire string representation of the URIs match
     *
     * @return bool
     */
    public function matchAll(): bool
    {
        return $this->equals(static function (UriInterface $uri): string {
            return (string) $uri;
        });
    }

    /**
     * Check whether all schemes match
     *
     * @return bool
     */
    public function matchScheme(): bool
    {
        return $this->equals(static function (UriInterface $uri): string {
            return $uri->getScheme();
        });
    }

    /**
     * Check whether all authority's match
     *
     * @return bool
     */
    public function matchAuthority(): bool
    {
        return $this->equals(static function (UriInterface $uri): string {
            return $uri->getAuthority();
        });
    }

    /**
     * Check whether all user info matches
     *
     * @return bool
     */
    public function matchUserInfo(): bool
    {
        return $this->equals(static function (UriInterface $uri): string {
            return $uri->getUserInfo();
        });
    }

    /**
     * Check whether all hosts match
     *
     * @return bool
     */
    public function matchHost(): bool
    {
        return $this->equals(static function (UriInterface $uri): string {
            return $uri->getHost();
        });
    }

    /**
     * Check whether all ports match
     *
     * @return bool
     */
    public function matchPort(): bool
    {
        return $this->equals(static function (UriInterface $uri): ?int {
            return $uri->getPort();
        });
    }

    /**
     * Check whether all paths match
     *
     * @return bool
     */
    public function matchPath(): bool
    {
        return $this->equals(static function (UriInterface $uri): string {
            return $uri->getPath();
        });
    }

    /**
     * Check whether all queries match
     *
     * @return bool
     */
    public function matchQuery(): bool
    {
        return $this->equals(static function (UriInterface $uri): string {
            return $uri->getQuery();
        });
    }

    /**
     * Check whether all fragments match
     *
     * @return bool
     */
    public function matchFragment(): bool
    {
        return $this->equals(static function (UriInterface $uri): string {
            return $uri->getFragment();
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
                array_map(static function (UriInterface $uri) use ($callback) {
                    return $callback($uri);
                }, $this->uris)
            )
        ) === 1;
    }
}
