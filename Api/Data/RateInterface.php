<?php

namespace EdmondsCommerce\Shipping\Api\Data;

interface RateInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getWebsiteId();

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @return string[]
     */
    public function getPostCodes();

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