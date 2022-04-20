# Boltmail Laravel Adaptor
A package for interacting with the Boltmail API with Laravel.

## Installation
1. Generate an API key pair through the Boltmail admin screen
1. Set the `BOLTMAIL_PUBLIC_KEY` variable in your .env
1. Publish the config file for this package with `php artisan vendor:publish --provider="AlexClark\Boltmail\BoltmailServiceProvider"`

## Usage
This package uses Laravel's service container and facades to call available methods statically.
If there's a method you need that's not built in to the facade, you can use the "call" method and provide the endpoint/params manually.

Check out `AlexClark\Boltmail\Boltmail` to see all built-in methods.

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AlexClark\Boltmail\Facades\Boltmail;

class SubscriberController extends Controller
{
    /**
     * Gets all lists from Boltmail
     */
    public function index()
    {
        Boltmail::getLists();
    }

    /**
     * Adds a subscriber to a specified list
     */
    public function store()
    {
        $listId = 'abcdef123';

        $subscriber = [
            'EMAIL' => 'example@example.com',
            'FNAME' => 'First',
            'LNAME' => 'Last'
        ];

        Boltmail::addSubscriber($listId, $subscriber);
    }
}

```
