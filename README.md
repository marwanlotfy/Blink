# Blink , Chat Package 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marwanlotfy/blink.svg?style=flat-square)](https://packagist.org/packages/marwanlotfy/blink)
[![Quality Score](https://img.shields.io/scrutinizer/g/marwanlotfy/blink.svg?style=flat-square)](https://scrutinizer-ci.com/g/marwanlotfy/blink)
[![Total Downloads](https://img.shields.io/packagist/dt/marwanlotfy/blink.svg?style=flat-square)](https://packagist.org/packages/marwanlotfy/blink)

Hii , Blink is a chat package integerate with laravel

it's easy to install , provides you with apis for chats,messages,message informations and support messages of type (text , images , voice , location and video )

## Features

- Restful APIs for Chat (create , list)
- Restful APIs for Message (create , list , get sended media)
- Supported Message Types (Audio , Video , Images , Text , Location )
- Restful APIs for Message Info ( list , seen , deliverd )

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

if you need your users hasChats you can use HasChats Trait
```php
use Blink\HasChats;
```
on your UserModel 

and add 
```php
use HasChats;
```
inside User class 

properties Added are 
```php
$user->chats;
$user->unBannedChats;
$user->bannedChats;
```
methodes Added are
```php
$user->leaveChat($chatId);
```

you can use Blink Facade 

```php
use Blink\Facades\Blink;

Blink::createChat(...$usersIds);
Blink::getChat($chatId)->delete();
Blink::getChat($chatId)->createTextMessage(String $body);
Blink::getChat($chatId)->unSuspend();
Blink::getChat($chatId)->suspend();
Blink::getChat($chatId)->banUsers(...$users);
Blink::getChat($chatId)->unBanUsers(...$users);
Blink::getChat($chatId)->markAsGroup($creatorId,$groupName,$description,$icon)->makeGroupAdmin(...$users);
```

You can keep adding admins to chat if is marked as Group 


when you create chat there is an event will be fired 

```php
Blink\Events\NewChatCreated
```
so you can listen on this event and handle the logic you want to notify your users 

the event has $chat property

when you send chat Message there is an event will be fired 

```php
Blink\Events\NewChatMessage
```
so you can listen on this event and handle the logic you want to notify your users  that new message created

the event has $message property



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email marwandevelop@gmail.com instead of using the issue tracker.

## Credits

- [Marwan Lotfy](https://github.com/marwanlotfy)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
