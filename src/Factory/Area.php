<?php

namespace Bitery\Factory;

use Bitery\Area as BaseArea;
use Bitery\Interface\Area as IArea;
use Bitery\Range;
use ValueError;


class Area
{
    public static function fromArray(array $area)
    {
        if (isset($area['bit']))
            $range = (new Range)->add($area['bit']);
        elseif (isset($area['bitStart'], $area['bitStart']))
            $range = Range::fromInterval($area['bitStart'], $area['bitEnd']);
        elseif (isset($area['range']) && $area['range'] instanceof IArea)
            $range = $area['range'];
        else
            throw new ValueError('The bit range is not specified!');

        return new BaseArea(
            $area['key'] ?? '',
            $range,
            $area['default'] ?? 0
        );
    }
}