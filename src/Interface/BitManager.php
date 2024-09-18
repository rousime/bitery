<?php

namespace Bitery\Interface;

use Stringable;


interface BitManager extends Stringable
{
    /**
     * @param string $bits The string that will be modified
     */
    public function __construct(string $bits = "");

    /**
     * Gets the value of a bit by its number $bitNum.
     * 
     * @param int $bitNum
     * 
     * @return bool
     */
    public function getBit(int $bitNum): bool;

    /**
     * Gets the value of the bits from the range $range.
     * 
     * @param Range $range
     * 
     * @return int
     */
    public function getBitRange(Range $range): int;

    /**
     * Sets the bit in the position $bitNum to a value $payload.
     * 
     * @param int $bitNum
     * @param bool $payload
     * 
     * @return static
     */
    public function setBit(int $bitNum, bool $payload = false): static;

    /**
     * Sets the value of the bits in the range $range to the value $payload
     * 
     * @param Range $range
     * @param int $payload
     * 
     * @return static
     */
    public function setBitRange(Range $range, int $payload = 0): static;

    /**
     * Clears all empty bytes in the row on the right.
     * 
     * @return static
     */
    public function clearEmptyBytes(): static;

    /**
     * Returns a string with modified bits.
     * 
     * @return string
     */
    public function getString(): string;
}