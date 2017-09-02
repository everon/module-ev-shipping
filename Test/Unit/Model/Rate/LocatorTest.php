<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Rate;

use EdmondsCommerce\Shipping\Model\Rate\Locator;
use EdmondsCommerce\Shipping\Test\Integration\IntegrationTestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Mockery\MockInterface;

class LocatorTest extends IntegrationTestCase
{
    /**
     * @var Locator
     */
    private $class;

    /**
     * @var MockInterface
     */
    private $config;

    /**
     * @var MockInterface
     */
    private $directory;

    public function setUp()
    {
        parent::setUp();

        $this->config    = $this->mock(ScopeConfigInterface::class);
        $this->directory = $this->mock(DirectoryList::class);

        $this->class = new Locator($this->config, $this->directory);
    }

    /**
     * @test
     */
    public function itWillUseConfigPathFirst()
    {
        $this->config->shouldReceive('getValue')->once()->with('ecshipping/file')
                     ->andReturn('var/rates.json');
        $this->directory->shouldReceive('getRoot')->once()->withNoArgs()
                        ->andReturn('/var/www/vhosts/magento');

        $result = $this->class->getRatePath();

        $this->assertEquals('/var/www/vhosts/magento/var/rates.json', $result);
    }

    /**
     * @test
     */
    public function itWillUseADefaultPathAfterConfig()
    {
        $this->config->shouldReceive('getValue')->once()->with('ecshipping/file')
                     ->andReturn('');
        $this->directory->shouldReceive('getPath')->once()->with('var')->andReturn('testpath');

        $result = $this->class->getRatePath();

        $this->assertEquals('testpath/shipping-config.json', $result);
    }
}
