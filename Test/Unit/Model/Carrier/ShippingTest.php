<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Carrier;

use EdmondsCommerce\Shipping\Model\Carrier\Shipping;
use EdmondsCommerce\Shipping\Test\Unit\UnitTestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Psr\Log\LoggerInterface;

class ShippingTest extends UnitTestCase
{
    /** @var  Shipping */
    protected $class;

    /** @var  \Magento\Framework\App\Config\ScopeConfigInterface  */
    protected $scopeConfig;

    /** @var  \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory  */
    protected $rateErrorFactory;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    public function setUp()
    {
        parent::setUp();

        $this->scopeConfig = $this->mock(ScopeConfigInterface::class);
        $this->rateErrorFactory = $this->mock('\Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory');
        $this->logger = $this->mock(LoggerInterface::class);

        $this->class = new Shipping($this->scopeConfig, $this->rateErrorFactory, $this->logger);
    }

    /** @test */
    public function itCanGetTheShippingRates()
    {
        $request = $this->mock(RateRequest::class);

        $this->class->collectRates($request);
    }
}