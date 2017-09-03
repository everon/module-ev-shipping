<?php

namespace Everon\EvShipping\Test\Integration;

use Everon\EvShipping\Test\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    protected function getFileDir()
    {
        return __DIR__ . '/_files';
    }
}
