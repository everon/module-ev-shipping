<?php

namespace Everon\EvShipping\Controller\Adminhtml\Rates;

use Everon\EvShipping\Controller\Adminhtml\Rates;

class Index extends Rates
{

    public function execute()
    {
        $result = $this->_initAction();
        return $result;
    }
}
