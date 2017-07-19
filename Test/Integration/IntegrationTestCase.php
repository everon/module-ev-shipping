<?php

namespace EdmondsCommerce\Shipping\Test\Integration;

use EdmondsCommerce\Shipping\Test\TestCase;

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