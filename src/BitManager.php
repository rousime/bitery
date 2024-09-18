<?php

namespace Bitery;

use Bitery\Interface\Range as IRange;

use function ord;
use function chr;
use function rtrim;


class BitManager implements Interface\BitManager
{
    const BASEBITS = 0b10000000;

    const BASEBITS_R = 0b1;

    /**
     * A string for storing data that has been modified.
     * 
     * @var string
     */
    protected string $bits;

    /**
     * @param string $bits
     */
    public function __construct(string $bits = "")
    {
        $this->bits = $bits;
    }

    /**
     * {@inheritdoc }
     * 
     * @return bool
     */
    public function getBit(int $bitNum): bool
    {
        return @(
            ord($this->bits[
                $this->getByteByBit($bitNum)
            ]) & static::BASEBITS>>$this->getBitByBit($bitNum)
        );
    }

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function setBit(int $bitNum, bool $payload = false): static
    {
        if ($this->getBit($bitNum) == $payload)
            return $this;

        $byteNum = $this->getByteByBit($bitNum);
        $bitNum = $this->getBitByBit($bitNum);

        $this->bits[$byteNum] = chr(
            ord(
                $this->bits[$byteNum] ?? ''
            ) ^ static::BASEBITS>>$bitNum
        );

        return $this;
    }

    /**
     * {@inheritdoc }
     * 
     * @return int
     */
    public function getBitRange(IRange $range): int
    {
        $result = 0;
        $summand = static::BASEBITS_R;

        foreach($range as $pos)
        {
            if ($this->getBit($pos))
            {
                $result += $summand;
            }

            $summand <<= 1;
        }

        return $result;
    }

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function setBitRange(IRange $range, int $payload = 0): static
    {
        $checker = static::BASEBITS_R;

        foreach($range as $pos)
        {
            $this->setBit(
                $pos,
                (bool) ($payload & $checker)
            );

            $checker <<= 1;
        }

        return $this;
    }

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function clearEmptyBytes(): static
    {
        $this->bits = rtrim($this->bits);

        return $this;
    }

    /**
     * {@inheritdoc }
     * 
     * @return string
     */
    public function getString(): string
    {
        return $this->bits;
    }

    /**
     * Alias for Bitery\BitManager::getString()
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->getString();
    }

    /**
     * Gets the byte number by the bit number.
     * 
     * @param int $bitNum
     * 
     * @return int
     */
    protected function getByteByBit(int $bitNum): int
    {
        return \intdiv($bitNum, 8);
    }

    /**
     * Gets the bit number in a byte by the common bit number.
     * 
     * @param int $bitNum
     * 
     * @return int
     */
    protected function getBitByBit(int $bitNum): int
    {
        return $bitNum%8;
    }
}