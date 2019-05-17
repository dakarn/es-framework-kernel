<?php

namespace ElasticSearch\Response\ResponseItems;

use Helper\AbstractList;

class HitsItemList extends AbstractList
{
    /**
     * @return string
     */
    public function getMappingClass(): string
    {
        return HitsItem::class;
    }
}