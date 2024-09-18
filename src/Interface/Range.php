<?php

namespace Bitery\Interface;

use IteratorAggregate;


interface Range extends IteratorAggregate
{
    /**
     * Adds one position to the range.
     * 
     * The position MUST be added even if it is already in the range!
     * 
     * @param int $num
     * 
     * @return static
     * 
     * @throws ValueError if $num < 0
     */
    public function add(int $num): static;

    /**
     * Adds an interval of positions to the range.
     * 
     * The interval MUST be added, even if it touches
     * or overlaps an already added interval!
     * 
     * @param int $start
     * @param int $end
     * 
     * @return static
     * 
     * @throws RangeException if $start > $end
     * @throws ValueError if $start < 0
     */
    public function addInterval(int $start, int $end): static;

    /**
     * Returns the total length (in bits) of the range.
     * 
     * @return int
     */
    public function getLength(): int;
}