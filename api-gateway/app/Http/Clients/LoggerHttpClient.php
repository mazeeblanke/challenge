<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class LoggerHttpClient
 * @package App\Http\Clients
 * @author mazino ukah <ewomaukah@yahoo.com>
 */
class LoggerHttpClient
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
        $this->client = new Client(['base_uri' => 'logger-interface/api/v1/logger/']);
    }

    /**
     * @param array $products
     * @return Collection
     */
    public function createLog($data)
    {
        try {
            $this->client->post('createLog', [
                'form_params' => [
                    'log' => $data
                ]
            ]);
        } catch (BadResponseException $exception) {

            throw new HttpException(
                $exception->getCode(),
                json_decode($exception->getResponse()->getBody()->getContents())
            );
        }

        // return new Collection($res);
    }
}
