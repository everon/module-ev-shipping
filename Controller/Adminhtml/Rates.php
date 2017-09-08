<?php

namespace Everon\EvShipping\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

abstract class Rates extends Action
{
    /**
     * @var Action\Context
     */
    private $context;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->context     = $context;
        $this->pageFactory = $pageFactory;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        $page = $this->pageFactory->create();
        $page->setActiveMenu('Magento_Sales::sales_operation');
        $page->addBreadcrumb(__('Shipping Rates'), __('Shipping Rates'));
        $page->getConfig()->getTitle()->prepend('EV Shipping');

        return $page;
    }
}
