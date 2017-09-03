<?php

namespace Everon\EvShipping\Api\Data;

interface RateCollectionInterface
{
    /**
     * @return RateInterface[]
     */
    public function toArray();
}
