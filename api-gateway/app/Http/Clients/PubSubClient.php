<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class PubSubClient
 * @package App\Http\Clients
 * @author mazino ukah <ewomaukah@yahoo.com>
 */
class PubSubClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * UserHttpClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'pubsub-interface/api/v1/logger/']);
    }

    /**
     * @param array $products
     * @return Collection
     */
    public function createLog($data)
    {
        try {
            $this->client->post('createLog', [
                'log' => $data
            ]);

            // return success
        } catch (BadResponseException $exception) {
            throw new HttpException(
                $exception->getCode(),
                json_decode($exception->getResponse()->getBody()->getContents())
            );
        }

    }
}
