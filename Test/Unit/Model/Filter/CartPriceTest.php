<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Filter;

use EdmondsCommerce\Shipping\Model\Filter\CartPrice;
use Mockery\MockInterface;

class CartPriceTest extends AbstractRangeFilterTest {
	/** @var  CartPrice */
	protected $class;

	public function setUp() {
		parent::setUp();

		$this->class = new CartPrice();
	}

	/**
	 * @param $count int Scalar value to set
	 *
	 * @return MockInterface
	 */
	protected function getRangedRequestMock( $price ) {
		$result = [];


		return $this->getRateRequestMock()->shouldReceive( 'getOrderSubtotal' )->andReturn( $result )->getMock();
	}

	/**
	 * @param null $from
	 * @param null $to
	 *
	 * @return MockInterface
	 */
	protected function getRangedRateMock( $from = null, $to = null ) {
		return $this->getRateMock()->shouldReceive( [
			'getCartPriceFrom' => $from,
			'getCartPriceTo'   => $to
		] )->getMock();
	}
}