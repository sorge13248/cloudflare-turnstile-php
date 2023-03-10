# Cloudflare Turnstile
An unofficial PHP package to validate Cloudflare Turnstile captchas with ease. Read more at the [Cloudflare official documentation](https://developers.cloudflare.com/turnstile/).

## Requirements
- PHP >= 8.1

## Getting started
1. Download this package with Composer
```shell
composer require fsorge/cloudflare-turnstile-php
```

2. Create a new `Turnstile` instance
```php
use Fsorge\Cloudflare\Turnstile;

$turnstile = new Turnstile('YOUR_SECRET_KEY');
```

3. Call the `isValid()` method
```php
$isCaptchaValid = $turnstile->isValid('RESPONSE_FROM_CLIENT');
```

4. That's it!

## Dictionary
- **YOUR_SECRET_KEY**: you can retrieve your secret key by going to your Cloudflare Turnstile dashboard, clicking "Settings" on your website, expanding the "Secret key" section and copying the key somewhere in your project and passing it to the `Turnstile` constructor
- **RESPONSE_FROM_CLIENT**: it's a hidden field (with the `name` attribute set to `cf-turnstile-response`) that the Turnstile client-side widget automatically creates in your form. You have to pass that field's value.

## Full simple example
```php
use Fsorge\Cloudflare\Turnstile;

$turnstile = new Turnstile('0x......');

$isCaptchaValid = $turnstile->isValid('0.id8uAhu.....');

if ($isCaptchaValid) {
    // Captcha has been validated
} else {
    // Captcha NOT validate
}
```

## Detailed response
If you need to have the full response from the Cloudflare Turnstile API, you can call the `validate()` method instead of the `isValid()`.

`validate()` returns an associative array with the whole response from the Cloudflare API, containing useful information like occurred errors if any.