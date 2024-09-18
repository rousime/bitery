<?php

namespace Bitery;

use Bitery\Interface\Range as IRange;


class Area implements Interface\Area
{
    /**
     * Key of area.
     * 
     * @var string
     */
    protected string $key;

    /**
     * Range of area.
     * 
     * @var IRange
     */
    protected IRange $range;

    /**
     * Default value of area.
     * 
     * @var int
     */
    protected int $default;

    /**
     * @param string $key
     * @param IRange $range
     * @param int $default
     */
    public function __construct(string $key, IRange $range, int $default = 0)
    {
        $this->key = $key;
        $this->withRange($range);
        $this->withDefault($default);
    }

    /**
     * {@inheritdoc }
     * 
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function withDefault(int $default): static
    {
        $this->default = $default;

        return $this;
    }

    /**
     * {@inheritdoc }
     * 
     * @return int
     */
    public function getDefault(): int
    {
        return $this->default;
    }

    /**
     * {@inheritdoc }
     * 
     * @return static
     */
    public function withRange(IRange $range): static
    {
        $this->range = $range;

        return $this;
    }

    /**
     * {@inheritdoc }
     * 
     * @return IRange
     */
    public function getRange(): IRange
    {
        return $this->range;
    }
}