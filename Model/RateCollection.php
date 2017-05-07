<?php

namespace EdmondsCommerce\Shipping\Model;

class RateCollection
{
    /** @var Rate[] */
    protected $items;
    /**
     * @var RuleCollectionFactory
     */
    private $ruleCollectionFactory;

    /**
     * RuleCollection constructor.
     * @param Rate[] $items
     * @param RuleCollectionFactory $ruleCollectionFactory
     */
    public function __construct(array $items, RuleCollectionFactory $ruleCollectionFactory)
    {
        $this->items = $items;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
    }

    /**
     * @param $websiteCode
     * @return RateCollection
     */
    public function filterWebsite($websiteCode)
    {
        $items = array_filter($this->items, function(Rate $item) use ($websiteCode)
        {
            return $item->getWebsiteId() == $websiteCode;
        });

        return $this->ruleCollectionFactory->create($items);
    }

    /**
     * @param $countryCode
     * @return RateCollection
     */
    public function filterCountry($countryCode)
    {
        $items = array_filter($this->items, function (Rate $item) use ($countryCode)
        {
            return $item->getCountry() == $countryCode;
        });

        return $this->ruleCollectionFactory->create($items);
    }

    /**
     * @param $postcode
     * @return RateCollection
     */
    public function filterPostcode($postcode)
    {
        $items = array_filter($this->items, function (Rate $item) use ($postcode)
        {
            return $item->matchPostcode($postcode);
        });

        return $this->ruleCollectionFactory->create($items);
    }

    public function toArray()
    {
        return $this->items;
    }
}