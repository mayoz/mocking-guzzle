<?php

namespace App\Tests;

use App\TodoService;

class ServiceTest extends TestCase
{
    /**
     * The service instance to be tested.
     *
     * @var TodoService
     */
    protected $todoService;

    /**
     * Setup the test case.
     *
     * @return void
     */
    public function setUp()
    {
        $this->todoService = new TodoService(
            $this->getHttpClient()
        );
    }

    /**
     * Test the fetch method for success request.
     *
     * @return void
     */
    public function testFetchForSuccess()
    {
        $this->mockRequest('found.txt');

        $response = $this->todoService->find(1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(83, $response->getHeaderLine('Content-Length'));

        $contents = json_decode($response->getBody()->getContents(), true);

        $this->assertSame([
            'userId' => 1,
            'id' => 1,
            'title' => 'delectus aut autem',
            'completed' => false
        ], $contents);
    }

    /**
     * Test the fetch method for failed request.
     *
     * @return void
     *
     * @expectedException     GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 404
     */
    public function testFetchForNotFound()
    {
        $this->mockRequest('not-found.txt');

        $this->todoService->find(1000);
    }
}
