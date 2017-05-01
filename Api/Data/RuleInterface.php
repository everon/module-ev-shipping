<?php

namespace EdmondsCommerce\Shipping\Api\Data;

interface RuleInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @return string
     */
    public function getPostCode();

    /**
     * @return float
     */
    public function getWeightFrom();

    /**
     * @return float
     */
    public function getWeightTo();

    /**
     * @return float
     */
    public function getPriceFrom();

    /**
     * @return float
     */
    public function getPriceTo();

    /**
     * @return float
     */
    public function getShippingPrice();

    /**
     * @return int
     */
    public function getSortOrder();
}