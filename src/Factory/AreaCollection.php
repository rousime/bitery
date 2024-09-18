<?php

namespace Bitery\Factory;

use Bitery\AreaCollection as AreaCollectionBase;


class AreaCollection
{
    public static function fromArray(array $areas): AreaCollectionBase
    {
        $collection = new AreaCollectionBase;

        foreach($areas as $area)
        {
            if (!is_array($area))
                continue;

            $collection->withArea(Area::fromArray($area));
        }

        return $collection;
    }
}