<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Filter;

use EdmondsCommerce\Shipping\Model\Filter\ItemCount;
use Mockery\MockInterface;

class ItemCountTest extends AbstractRangeFilterTest
{
    /** @var  ItemCount */
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->class = new ItemCount();
    }

	/**
	 * @param $count int Scalar value to set
	 *
	 * @return MockInterface
	 */
	protected function getRangedRequestMock( $count ) {
        return $this->getRateRequestMock()->shouldReceive('getPackageQty')->andReturn($count)->getMock();
	}

	/**
	 * @param null $from
	 * @param null $to
	 *
	 * @return MockInterface
	 */
	protected function getRangedRateMock( $from = null, $to = null ) {
		return $this->getRateMock()->shouldReceive([
			'getItemsFrom' => $from,
			'getItemsTo' => $to
		])->getMock();
	}
}