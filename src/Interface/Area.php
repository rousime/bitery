<?php

namespace Bitery\Interface;


interface Area
{
    /**
     * @param string $key Area key
     * @param Range $range
     * @param int $default Default value for this area
     */
    public function __construct(string $key, Range $range, int $default = 0);

    /**
     * Gets the area key.
     * 
     * @return string
     */
    public function getKey(): string;

    /**
     * Changes the default value of this area.
     * 
     * @param int $default Default value for this area
     * 
     * @return static
     */
    public function withDefault(int $default): static;

    /**
     * Gets the default value of this area.
     * 
     * @return int
     */
    public function getDefault(): int;

    /**
     * Changes the range of this area.
     * 
     * @param Range $range
     * 
     * @return static
     */
    public function withRange(Range $range): static;

    /**
     * Gets the range of this area.
     * 
     * @return Range
     */
    public function getRange(): Range;
}