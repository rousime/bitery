<?php

namespace Bitery;

use ValueError;
use RangeException;
use Traversable;

use function array_push;
use function count;


class Range implements Interface\Range
{
    protected array $positions = [];

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function add(int $num): static
    {
        if ($num < 0)
            throw new ValueError("The position cannot be less than zero!");

        array_push($this->positions, $num);

        return $this;
    }

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function addInterval(int $start, int $end): static
    {
        if ($start > $end)
            throw new RangeException("The first position cannot be larger than the last position!");
        if ($start < 0)
            throw new ValueError("The position cannot be less than zero!");

        if ($start == $end)
            $this->addBit($start);

        array_push($this->positions, [$start, $end]);

        return $this;
    }

    /**
     * Returns the positions of all the bits of the range in reverse order.
     * 
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        for($i = count($this->positions) - 1; $i >= 0; $i--)
        {
            $value =& $this->positions[$i];

            if (is_int($value))
            {
                yield $value;
            }
            else
            {
                for ($j = $value[1]; $j >= $value[0]; $j--)
                {
                    yield $j;
                }
            }
        }
    }

    /**
     * {@inheritdoc }
     * 
     * @return int
     */
    public function getLength(): int
    {
        $i = 0;
        foreach ($this as $_) $i++;

        return $i;
    }

    /**
     * Returns a new range instance with the interval from $start to $end.
     * 
     * @param int $start
     * @param int $end
     * 
     * @return static
     */
    public static function fromInterval(int $start, int $end): static
    {
        return (new (self::class))
            ->addInterval($start, $end);
    }
}