<?php

namespace Bitery\Interface;

use IteratorAggregate;


interface AreaCollection extends IteratorAggregate
{
    /**
     * Adds a area to the collection.
     * If a area with the same key exists, then the area is overwritten.
     * 
     * @param Area $area
     * 
     * @return static
     */
    public function withArea(Area $area): static;

    /**
     * Deletes a area from the collection by a string key
     * or by a key from an area instance.
     * 
     * @param Area|string $area
     * 
     * @return static
     */
    public function withoutArea(Area|string $area): static;

    /**
     * Gets the area by the string key.
     * Otherwise, null is returned.
     * 
     * @param string $key
     * 
     * @return Area|null
     */
    public function getArea(string $key): Area|null;
}