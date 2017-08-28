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
	 * @param int $price
	 * @return MockInterface
	 * @internal param int $count
	 */
	protected function getRangedRequestMock( $price ) {
		return $this->getRateRequestMock()->shouldReceive( 'getOrderSubtotal' )->andReturn( $price )->getMock();
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