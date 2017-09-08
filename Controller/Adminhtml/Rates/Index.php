<?php

namespace Everon\EvShipping\Controller\Adminhtml\Rates;

use Magento\Backend\App\Action;

class Index extends Action
{
    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Magento_Sales::sales_operation');

        $this->_addBreadcrumb(__('EV Shipping'), __('EV Shipping'));
        $this->_view->renderLayout();
    }
}
