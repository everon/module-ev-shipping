<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model;

use EdmondsCommerce\Shipping\Model\Upload\Importer;
use EdmondsCommerce\Shipping\Model\Upload\ValidationException;
use EdmondsCommerce\Shipping\Model\Upload\Validator;
use EdmondsCommerce\Shipping\Test\Unit\UnitTestCase;
use Mockery\Mock;


class ImporterTest extends UnitTestCase
{
    /** @var Mock */
    protected $validator;

    /** @var Importer */
    protected $importer;

    public function setUp()
    {
        parent::setUp();

        $this->validator = $this->mock(Validator::class);
        $this->importer = new Importer($this->validator);
    }

    /**
     * @test
     */
    public function itWillFailOnValidationFailure()
    {
        $file = 'test.csv';
        $exception = $this->mock(ValidationException::class);
        $this->validator->shouldReceive('validate')->once()->andThrow($exception);

        $result = $this->importer->import($file);

        $this->assertInternalType('array', $result);
    }
}
