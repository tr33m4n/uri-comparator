# url-object
A URL value object. Some inspiration taken from https://developer.mozilla.org/en-US/docs/Web/API/URL/URL

## Installing
```sh
composer require tr33m4n/url-object
```

## How to use
### `fromString`
```php
$url = \tr33m4n\UrlObject\Url::fromString('https://example.com');

echo $url->getScheme();
echo $url->getHost();
// https
// example.com
// etc...
```
### `create`
```php
echo \tr33m4n\UrlObject\Url::create()
    ->withScheme('https')
    ->withHost('example.com')
    ->withUser('test')
    ->withPass('example')
    ->withPort(1234);
// https://test:example@example.com:1234
```
### Replacing parts of the URL
```php
$url = \tr33m4n\UrlObject\Url::fromString('https://example.com:1234');
echo $url->withHost('not-example.com');
// https://not-example.com:1234
```
### Getting URL params
```php
$url = \tr33m4n\UrlObject\Url::fromString('https://example.com:1234?this=test&another=something');
$allParameters = $url->getParameters();
// Will return an array of `\tr33m4n\UrlObject\UrlParameter`'s

$aSpecificParameter = $url->getParameter('this');
// Will return the "this" `\tr33m4n\UrlObject\UrlParameter`

echo $aSpecificParameter->getValue();
// "test"
```
### Comparing URL's
```php
$url = Url::fromString('https://example.com:1234?this=test&another=something');
$comparator = $url->compareWith(
    'https://example.com:1234',
    'https://another-example.com:1234?this=test&another=something',
    'https://example.com:1234',
    Url::fromString('https://example.com:1234?this=test&another=something'),
    \tr33m4n\UrlObject\Url::create()
        ->withScheme('https')
        ->withHost('example.com')
        ->withUser('test')
        ->withPass('example')
        ->withPort(1234)
    // etc...
);

var_dump($comparator->matchPort());
var_dump($comparator->matchHost());
var_dump($comparator->matchScheme());
var_dump($comparator->matchParameters());
// bool(true)
// bool(false)
// bool(true)
// bool(false)

// Calling the comparator outside of the URL object
$comparator = \tr33m4n\UrlObject\Comparator::compare(
    'https://example.com:1234',
    Url::fromString('https://example.com:1234'),
    \tr33m4n\UrlObject\Url::create()
        ->withScheme('https')
        ->withHost('example.com')
        ->withUser('test')
        ->withPass('example')
        ->withPort(1234)
    // etc...
);
```