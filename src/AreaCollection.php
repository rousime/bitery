<?php

namespace Bitery;

use Bitery\Interface\Area as IArea;
use ArrayIterator;
use Traversable;

use function is_string;


class AreaCollection implements Interface\AreaCollection
{
    /**
     * Array of areas.
     * 
     * @var array
     */
    protected array $areas = [];

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function withArea(IArea $area): static
    {
        $this->areas[
            $area->getKey()
        ] = $area;

        return $this;
    }

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function withoutArea(IArea|string $area): static
    {
        if (!is_string($area))
        {
            $area = $area->getKey();
        }

        unset($this->areas[$area]);

        return $this;
    }

    /**
     * {@inheritdoc }
     * 
     * @return IArea
     */
    public function getArea(string $key): IArea|null
    {
        return @$this->areas[$key];
    }

    /**
     * Returns an iterator that contains all the areas of this collection.
     * 
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->areas);
    }
}