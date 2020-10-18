# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marwanlotfy/blink.svg?style=flat-square)](https://packagist.org/packages/marwanlotfy/blink)
[![Quality Score](https://img.shields.io/scrutinizer/g/marwanlotfy/blink.svg?style=flat-square)](https://scrutinizer-ci.com/g/marwanlotfy/blink)
[![Total Downloads](https://img.shields.io/packagist/dt/marwanlotfy/blink.svg?style=flat-square)](https://packagist.org/packages/marwanlotfy/blink)

Hii , Blink is a chat package integerate with laravel

it's easy to install , provides you with apis for chats,messages,message informations and support messages of type (text , images , voice , location and video )


## Installation

You can install the package via composer:

```bash
composer require marwanlotfy/blink
```

## Usage

``` php
php artisan migrate
```
You need to publish config file and override the defaults options
``` php
php artisan vendor:publish --tag=blink-config
```

try 
``` php
php artisan route:list
```
it will list chat routes for you

Route Samples
![Blink APIs](https://github.com/marwanlotfy/Blink/blob/master/ChatAPIs.png)



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email marwandevelop@gmail.com instead of using the issue tracker.

## Credits

- [Marwan Lotfy](https://github.com/marwanlotfy)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
