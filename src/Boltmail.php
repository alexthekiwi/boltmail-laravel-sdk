<?php

namespace AlexClark\Boltmail;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Boltmail
{
    private $public_key;
    private $timestamp;
    private $api_url;

    public function __construct(string $public_key)
    {
        $this->public_key = $public_key;
        $this->timestamp = time();
        $this->api_url = 'https://app.boltmail.nz/api';
    }

    public function getBaseUrl()
    {
        return $this->api_url;
    }

    /**
     * Calls the Boltmail API
     *
     * @param string $endpoint (Slash prefixed endpoint, e.g. '/lists')
     * @param array $params (Request body)
     * @param string $method ('GET', 'POST', 'PUT', 'DELETE')
     * @return string
     * @throws RequestException
     */
    public function call(string $endpoint, array $params = [], string $method = 'GET')
    {
        try {
            $client = new Client();

            $headers = [
                'X-MW-PUBLIC-KEY' => $this->public_key,
                'X-MW-TIMESTAMP' => $this->timestamp,
            ];

            $res = $client->request($method, $this->getBaseUrl() . $endpoint, [
                'headers' => $headers,
                'form_params' => $params
            ]);

            return json_decode($res->getBody());
        } catch (RequestException $e) {
            return [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get all lists
     */
    public function getLists()
    {
        return $this->call('/lists');
    }

    /**
     * Gets a single list by ID
     *
     * @param string $listId
     */
    public function getList(string $listId)
    {
        return $this->call("/lists/{$listId}");
    }

    /**
     * Gets all segments from a list
     *
     * @param string $listId
     */
    public function getSegments(string $listId)
    {
        return $this->call("/lists/{$listId}/segments");
    }

    /**
     * Creates a list
     *
     * @param array $general
     * @param array $defaults
     * @see https://developer.boltmail.nz/#/API/LISTS/CREATE
     */
    public function createList(array $general, array $defaults)
    {
        $params = [
            'general' => $general,
            'defaults' => $defaults
        ];

        return $this->call("/lists", $params, 'POST');
    }

    /**
     * Updates a list
     *
     * @param string $listId
     * @param array $general
     * @param array $defaults
     * @see https://developer.boltmail.nz/#/API/LISTS/CREATE
     */
    public function updateList(string $listId, array $general, array $defaults)
    {
        $params = [
            'general' => $general,
            'defaults' => $defaults
        ];

        return $this->call("/lists/{$listId}", $params, 'PUT');
    }

    /**
     * Duplicates/Copies a list by ID
     *
     * @param string $listId
     * @param array $subscriber
     */
    public function copyList(string $listId)
    {
        return $this->call("/lists/{$listId}/copy", [], 'POST');
    }

    /**
     * Deletes a list by ID
     *
     * @param string $listId
     * @param array $subscriber
     */
    public function deleteList(string $listId)
    {
        return $this->call("/lists/{$listId}", [], 'DELETE');
    }

    /**
     * Adds a new subscriber to a specified list
     *
     * @param string $listId
     * @param array $subscriber
     */
    public function addSubscriber(string $listId, array $subscriber)
    {
        return $this->call("/lists/{$listId}/subscribers", $subscriber, 'POST');
    }

    /**
     * Adds multiple subscribers to the specified list
     *
     * @param string $listId
     * @param array $subscribers
     */
    public function addSubscribers(string $listId, array $subscribers)
    {
        return $this->call("/lists/{$listId}/subscribers/bulk", $subscribers, 'POST');
    }

    /**
     * Gets all subscribers in a list
     *
     * @param string $listId
     * @param array $subscriberId
     */
    public function getSubscribers(string $listId)
    {
        return $this->call("/lists/{$listId}/subscribers");
    }

    /**
     * Gets a single subscriber by ID
     *
     * @param string $listId
     * @param array $subscriberId
     */
    public function getSubscriber(string $listId, string $subscriberId)
    {
        return $this->call("/lists/{$listId}/subscribers/{$subscriberId}");
    }

    /**
     * Updates a subscriber's details
     *
     * @param string $listId
     * @param array $subscriberId
     */
    public function updateSubscriber(string $listId, string $subscriberId, array $params)
    {
        return $this->call("/lists/{$listId}/subscribers/{$subscriberId}", $params, 'PUT');
    }

    /**
     * Deletes a subscriber
     *
     * @param string $listId
     * @param array $subscriberId
     */
    public function deleteSubscriber(string $listId, string $subscriberId)
    {
        return $this->call("/lists/{$listId}/subscribers/{$subscriberId}", [], 'DELETE');
    }

    /**
     * Gets a subscribers ID by email
     */
    public function getSubscriberIdByEmail(string $listId, string $email)
    {
        return $this->call("/lists/{$listId}/subscribers/search-by-email?EMAIL={$email}");
    }

    /**
     * Gets a subscribers details by email
     */
    public function getSubscriberByEmail(string $listId, string $email)
    {
        try {
            $res = $this->getSubscriberIdByEmail($listId, $email);

            if (gettype($res) === 'array') {
                throw new \Exception("Couldn\'t find subscriber", 404);
            }

            $subscriberId = $res->data->subscriber_uid;
            return $this->getSubscriber($listId, $subscriberId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
