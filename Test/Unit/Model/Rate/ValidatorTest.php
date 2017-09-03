<?php

namespace Everon\EvShipping\Test\Unit\Model\Rate;

use Everon\EvShipping\Exception\ValidationShippingException;
use Everon\EvShipping\Model\Rate\Validator;
use Everon\EvShipping\Test\Integration\IntegrationTestCase;

class ValidatorTest extends IntegrationTestCase
{

    /**
     * @var Validator
     */
    private $class;


    public function setUp()
    {
        parent::setUp();

        $this->class = new Validator();
    }

    /**
     * @test
     */
    public function itWillFailWithNoRatesArray()
    {
        $input = ['test', 'fail'];

        $this->setExpectedException(ValidationShippingException::class, 'Rates is missing "rates" container');

        $this->class->validateJson($input);
    }

    /**
     * @test
     */
    public function itWillFailWhenRequiredItemsAreMissing()
    {
        $rate = [];

        $this->setExpectedException(
            ValidationShippingException::class,
            'Missing required rate fields: id, name, price'
        );

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
