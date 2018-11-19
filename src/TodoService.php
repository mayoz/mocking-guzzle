<?php

namespace App;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class TodoService
{
    /**
     * The implemented HTTP client instance.
     *
     * @var Client
     */
    protected $client;

    /**
     * Create a new TodoService instance.
     *
     * @param  Client  $client
     * @return void
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client;
    }

    /**
     * Get the todo for given ID.
     *
     * @param  int  $id
     * @return ResponseInterface
     */
    public function find(int $id): ResponseInterface
    {
        return $this->client->get("https://jsonplaceholder.typicode.com/todos/{$id}");
    }
}
