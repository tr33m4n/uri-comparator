# url-object
An URL value object to use in your favourite functional err, functions! Some inspiration taken from https://developer.mozilla.org/en-US/docs/Web/API/URL/URL

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
$url = (string) Url::create()
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
echo (string) $url->withHost('not-example.com');
// https://not-example.com:1234
```
