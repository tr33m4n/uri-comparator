# uri-comparator
This module facilitates the basic comparison of each component of a PSR-7 URI object

## Installing
```sh
composer require tr33m4n/uri-comparator
```

## How to use
```php
$comparator = \tr33m4n\UriComparator\Comparator::compare(
    'https://example.com:1234',
    'https://another-example.com:1234?this=test&another=something',
    \League\Uri\Http::createFromString('https://example.com:1234'),
    \League\Uri\Uri::createFromString('https://another-example.com:1234?this=test&another=something')
    // An instance of `\Psr\Http\Message\UriInterface`
    // etc...
);

var_dump($comparator->matchPort());
var_dump($comparator->matchHost());
var_dump($comparator->matchScheme());
var_dump($comparator->matchPath());
// bool(true)
// bool(false)
// bool(true)
// bool(true)

// From array of URI's
$comparator = \tr33m4n\UriComparator\Comparator::compareArray([
    'https://example.com:1234',
    'https://another-example.com:1234?this=test&another=something',
    \League\Uri\Http::createFromString('https://example.com:1234'),
    \League\Uri\Uri::createFromString('https://another-example.com:1234?this=test&another=something')
]);
```
