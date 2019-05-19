<?php

namespace ES\Kernel\ElasticSearch\Response\ResponseItems;

use ES\Kernel\Helper\AbstractList;

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