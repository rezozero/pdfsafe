# PdfSafe Twig extension

[![Packagist](https://img.shields.io/packagist/v/rezozero/pdfsafe.svg)](https://packagist.org/packages/rezozero/pdfsafe)


Clean a HTML/XML input to be generated in PDF by [psliwa/php-pdf](https://github.com/psliwa/PHPPdf) library.

## Install

```bash
composer require rezozero/pdfsafe
```

Add this extension in your Twig environment.

```php
use RZ\PdfSafe\PdfSafeExtension;
use Symfony\Component\HttpFoundation\Request;

$container->extend('twig.extensions', function ($extensions, $c) {
    /** @var Request $request */
    $request = $c['request'];
    $extensions->add(new PdfSafeExtension($request->getSchemeAndHttpHost()));
    return $extensions;
});
```
