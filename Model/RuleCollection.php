<?php

namespace EdmondsCommerce\Shipping\Model;

class RuleCollection
{
    /** @var Rule[] */
    protected $items;
    /**
     * @var RuleCollectionFactory
     */
    private $ruleCollectionFactory;

    /**
     * RuleCollection constructor.
     * @param Rule[] $items
     * @param RuleCollectionFactory $ruleCollectionFactory
     */
    public function __construct(array $items, RuleCollectionFactory $ruleCollectionFactory)
    {
        $this->items = $items;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
    }

    /**
     * @param $websiteCode
     * @return RuleCollection
     */
    public function filterWebsite($websiteCode)
    {
        $items = array_filter($this->items, function(Rule $item) use ($websiteCode)
        {
            return $item->getWebsiteId() == $websiteCode;
        });

        return $this->ruleCollectionFactory->create($items);
    }

    /**
     * @param $countryCode
     * @return RuleCollection
     */
    public function filterCountry($countryCode)
    {
        $items = array_filter($this->items, function (Rule $item) use ($countryCode)
        {
            return $item->getCountry() == $countryCode;
        });

        return $this->ruleCollectionFactory->create($items);
    }

    /**
     * @param $postcode
     * @return RuleCollection
     */
    public function filterPostcode($postcode)
    {
        $items = array_filter($this->items, function (Rule $item) use ($postcode)
        {
            $filter = $item->getPostCode();

        });

        return $this->ruleCollectionFactory->create($items);
    }
}