<?php

namespace Sitra\Tests;

use GuzzleHttp\Middleware;
use Sitra\ApiClient\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;

include(realpath(dirname(__FILE__)) . '/../config.inc.php');

abstract class Base extends TestCase
{
    protected $defaultOptions = [
        'apiKey' => 'XXX',
        'projectId' => 'XXX',
    ];

    protected $defaultExpected = [
        'responseFields' => '',
        'locales' => '',
        'apiKey' => 'XXX',
        'projetId' => 'XXX',
    ];

    /**
     * @var \Sitra\ApiClient\Client
     */
    protected $client;

    /**
     * @var Array
     */
    protected $historyContainer;
    protected $options;

    /**
     * @see https://docs.guzzlephp.org/en/stable/testing.html
     */
    protected function getClient($requestCount = 1, $options = null)
    {
        if ($options == null && file_exists(realpath(dirname(__FILE__)) . '/../config.inc.php')) {
            include(realpath(dirname(__FILE__)) . '/../config.inc.php');
            $options = $config;
        }

        if ($options == null) $options = $this->defaultOptions;

        $this->historyContainer = [];

        if ($requestCount > 0) {
            $mocks = [];
            while (count($mocks) < $requestCount) {
                $mocks[] = new Response(200);
            }
            $handlerStack = HandlerStack::create(new MockHandler($mocks));
        } else $handlerStack = HandlerStack::create();

        $handlerStack->push(Middleware::history($this->historyContainer));

        $options['handler'] = $handlerStack;

        $this->options = $options;

        $this->client = new Client($options);
        return $this->client;
    }

    protected function lastPath()
    {
        return $this->lastRequest()->getUri()->getPath();
    }
    protected function lastQuery()
    {
        var_dump($this->lastRequest()->getUri());
        $query = $this->lastRequest()->getUri()->getQuery();
        parse_str($query, $output);
        return $output;
    }
    private function lastRequest()
    {
        $lastEntry = array_values(array_slice($this->historyContainer, -1))[0];
        return $lastEntry['request'];
    }
}
