<?php

namespace AlexClark\Boltmail\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static App\Boltmail\Boltmail getLists()
 * @method static App\Boltmail\Boltmail getList(string $listId)
 * @method static App\Boltmail\Boltmail getSegments(string $listId)
 * @method static App\Boltmail\Boltmail createList(array $general, array $defaults)
 * @method static App\Boltmail\Boltmail updateList(string $listId, array $general, array $defaults)
 * @method static App\Boltmail\Boltmail copyList(string $listId)
 * @method static App\Boltmail\Boltmail deleteList(string $listId)
 * @method static App\Boltmail\Boltmail getSubscribers(string $listId)
 * @method static App\Boltmail\Boltmail getSubscriber(string $listId, $string $subscriberId)
 * @method static App\Boltmail\Boltmail getSubscriberIdByEmail(string $listId, $string $email)
 * @method static App\Boltmail\Boltmail getSubscriberByEmail(string $listId, $string $email)
 * @method static App\Boltmail\Boltmail addSubscriber(string $listId, array $subscriber)
 * @method static App\Boltmail\Boltmail addSubscribers(string $listId, array $subscribers)
 * @method static App\Boltmail\Boltmail updateSubscriber(string $listId, $string $subscriberId, array $params)
 * @method static App\Boltmail\Boltmail deleteSubscriber(string $listId, $string $subscriberId)
 */
class Boltmail extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'boltmail';
    }
}
