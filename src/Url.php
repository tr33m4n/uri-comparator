<?php

declare(strict_types=1);

namespace tr33m4n\UrlObject;

use tr33m4n\UrlObject\Exception\UrlException;

/**
 * Class Url
 *
 * @package tr33m4n\UrlObject
 */
class Url
{
    /**
     * @var string|null
     */
    private $scheme;

    /**
     * @var string|null
     */
    private $user;

    /**
     * @var string|null
     */
    private $pass;

    /**
     * @var string|null
     */
    private $host;

    /**
     * @var int|null
     */
    private $port;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var \tr33m4n\UrlObject\UrlParameter[]
     */
    private $parameters = [];

    /**
     * @var string|null
     */
    private $fragment;

    /**
     * Url constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * Create
     *
     * @return \tr33m4n\UrlObject\Url
     */
    public static function create(): Url
    {
        return new self();
    }

    /**
     * Create from string
     *
     * @throws \tr33m4n\UrlObject\Exception\UrlException
     * @param string $url
     * @return \tr33m4n\UrlObject\Url
     */
    public static function fromString(string $url): Url
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new UrlException(sprintf('"%s" is not a valid URL', $url));
        }

        $urlParts = parse_url($url);
        if (!$urlParts) {
            throw new UrlException(sprintf('"%s" is not a valid URL', $url));
        }

        return array_reduce(
            array_keys($urlParts),
            static function (Url $url, string $urlPartKey) use ($urlParts) {
                if (!method_exists($url, 'with' . ucfirst($urlPartKey))) {
                    return $url;
                }

                return $url = $url->{'with' . ucfirst($urlPartKey)}($urlParts[$urlPartKey]);
            },
            new self()
        );
    }

    /**
     * With scheme
     *
     * @param string|null $scheme
     * @return \tr33m4n\UrlObject\Url
     */
    public function withScheme(?string $scheme): Url
    {
        $url = clone $this;
        $url->scheme = $scheme;

        return $url;
    }

    /**
     * With user
     *
     * @param string|null $user
     * @return \tr33m4n\UrlObject\Url
     */
    public function withUser(?string $user): Url
    {
        $url = clone $this;
        $url->user = $user;

        return $url;
    }

    /**
     * With pass
     *
     * @param string|null $pass
     * @return \tr33m4n\UrlObject\Url
     */
    public function withPass(?string $pass): Url
    {
        $url = clone $this;
        $url->pass = $pass;

        return $url;
    }

    /**
     * With host
     *
     * @param string|null $host
     * @return \tr33m4n\UrlObject\Url
     */
    public function withHost(?string $host): Url
    {
        $url = clone $this;
        $url->host = $host;

        return $url;
    }

    /**
     * With port
     *
     * @param int|null $port
     * @return \tr33m4n\UrlObject\Url
     */
    public function withPort(?int $port): Url
    {
        $url = clone $this;
        $url->port = $port;

        return $url;
    }

    /**
     * With path
     *
     * @param string|null $path
     * @return \tr33m4n\UrlObject\Url
     */
    public function withPath(?string $path): Url
    {
        $url = clone $this;
        $url->path = $path;

        return $url;
    }

    /**
     * With query
     *
     * @param string $query
     * @return \tr33m4n\UrlObject\Url
     */
    public function withQuery(string $query): Url
    {
        parse_str($query, $queryParts);

        return $this->withParameters($queryParts);
    }

    /**
     * With parameter
     *
     * @param string     $key
     * @param int|string $value
     * @return \tr33m4n\UrlObject\Url
     */
    public function withParameter(string $key, $value): Url
    {
        $url = clone $this;
        $url->parameters[$key] = UrlParameter::from($key, $value);

        return $url;
    }

    /**
     * With parameters
     *
     * @param array<string, mixed> $parameters
     * @return \tr33m4n\UrlObject\Url
     */
    public function withParameters(array $parameters): Url
    {
        return array_reduce(
            array_keys($parameters),
            static function (Url $url, string $parameterKey) use ($parameters): Url {
                return $url = $url->withParameter($parameterKey, $parameters[$parameterKey]);
            },
            clone $this
        );
    }

    /**
     * With fragment
     *
     * @param string|null $fragment
     * @return \tr33m4n\UrlObject\Url
     */
    public function withFragment(?string $fragment): Url
    {
        $url = clone $this;
        $url->fragment = $fragment;

        return $url;
    }

    /**
     * Get scheme
     *
     * @return string|null
     */
    public function getScheme(): ?string
    {
        return $this->scheme;
    }

    /**
     * Get user
     *
     * @return string|null
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * Get pass
     *
     * @return string|null
     */
    public function getPass(): ?string
    {
        return $this->pass;
    }

    /**
     * Get host
     *
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * Get port
     *
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * Get path
     *
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * Get parameters
     *
     * @return \tr33m4n\UrlObject\UrlParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Get parameter
     *
     * @throws \tr33m4n\UrlObject\Exception\UrlException
     * @param string $key
     * @return \tr33m4n\UrlObject\UrlParameter
     */
    public function getParameter(string $key): UrlParameter
    {
        if (!array_key_exists($key, $this->parameters)) {
            throw new UrlException(sprintf('"%s" is not a valid parameter', $key));
        }

        return $this->parameters[$key];
    }

    /**
     * Get fragment
     *
     * @return string|null
     */
    public function getFragment(): ?string
    {
        return $this->fragment;
    }

    /**
     * Concatenate properties to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '%s%s%s%s%s/%s%s%s',
            $this->getScheme() ? $this->getScheme() . '://' : '',
            $this->getUserString(),
            $this->getPass() ? $this->getPass() . '@' : '',
            $this->getHost(),
            $this->getPort() ? ':' . $this->getPort() : '',
            $this->getPath() ? ltrim($this->getPath() ?? '', '/') : '',
            !empty($this->getParameters())
                ? '?' . http_build_query(array_reduce(
                    $this->getParameters(),
                    static function (array $parametersAsArray, UrlParameter $urlParameter): array {
                        return $parametersAsArray = array_merge(
                            $parametersAsArray,
                            [$urlParameter->getKey() => $urlParameter->getValue()]
                        );
                    },
                    []
                ))
                : '',
            $this->getFragment() ? '#' . $this->getFragment() : ''
        );
    }

    /**
     * Get user string
     *
     * @return string
     */
    private function getUserString(): string
    {
        if (!$this->getUser()) {
            return '';
        }

        if ($this->getPass()) {
            return $this->getUser() . ':';
        }

        return $this->getUser() . '@';
    }
}
