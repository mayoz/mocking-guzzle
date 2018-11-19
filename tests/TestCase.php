<?php

namespace App\Tests;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * The being HTTP client instance.
     *
     * @var Client;
     */
    protected $httpClient;

    /**
     * The being mock handler instance.
     *
     * @var MockHandler
     */
    protected $mockHandler;

    /**
     * Get the HTTP client instance.
     *
     * @return Client
     */
    final protected function getHttpClient(): Client
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client([
                'handler' => HandlerStack::create($this->getMockHandler()),
            ]);
        }

        return $this->httpClient;
    }

    /**
     * Get the mock handler instance.
     *
     * @return MockHandler
     */
    final protected function getMockHandler(): MockHandler
    {
        if (is_null($this->mockHandler)) {
            $this->mockHandler = new MockHandler();
        }

        return $this->mockHandler;
    }

    /**
     * Mock the HTTP client response with given mock file.
     *
     * @param  string  $filename
     * @return void
     */
    final protected function mockRequest($filename): void
    {
        $mockResponse = $this->loadMockResponse($filename);

        $parsedResponse = Psr7\parse_response($mockResponse);

        $this->mockHandler->append($parsedResponse);
    }

    /**
     * Load the mock file.
     *
     * @param  string  $filename
     * @return string
     */
    final protected function loadMockResponse($filename): string
    {
        return file_get_contents(__DIR__ .'/Mock/'. ltrim($filename, '/'));
    }
}
