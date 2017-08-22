<?php

namespace EdmondsCommerce\Shipping\Test\Integration\Model\Rate;

use EdmondsCommerce\Shipping\Model\Rate\Loader;
use EdmondsCommerce\Shipping\Test\Integration\IntegrationTestCase;

class LoaderTest extends IntegrationTestCase
{
	/**
	 * @var Loader
	 */
	private $class;

	public function setUp()
	{
		parent::setUp();

		$this->class = $this->_objectManager->create(Loader::class);
	}
}