<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Rate;

use EdmondsCommerce\Shipping\Exception\ValidationException;
use EdmondsCommerce\Shipping\Model\Rate\Validator;
use EdmondsCommerce\Shipping\Test\Integration\IntegrationTestCase;

class ValidatorTest extends IntegrationTestCase {

	/**
	 * @var Validator
	 */
	private $class;


	public function setUp() {
		parent::setUp();

		$this->class = new Validator();
	}

	/**
	 * @test
	 */
	public function itWillFailWithNoRatesArray() {
		$input = [ 'test', 'fail' ];

		$this->setExpectedException( ValidationException::class, 'Rates is missing "rates" container' );

		$this->class->validateJson( $input );
	}

	/**
	 * @test
	 */
	public function itWillFailWhenRequiredItemsAreMissing() {
		$rate = [];

		$this->setExpectedException(ValidationException::class, 'Missing required rate fields: id, name, price');

		$this->class->validateRate($rate);
	}

	/**
	 * @test
	 */
	public function itWillPassWithAnEmptyRatesArray()
	{
		$input = ['rates' => []];

		$result = $this->class->validateJson($input);

		$this->assertTrue($result);
	}
}