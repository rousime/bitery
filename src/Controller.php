<?php

namespace Bitery;

use Bitery\Interface\Area as IArea;
use Bitery\Interface\BitManager as IBitManager;


class Controller
{
    /**
     * @var IArea
     */
    protected IArea $area;

    /**
     * @var IBitManager
     */
    protected IBitManager $bits;

    /**
     * @param IArea $area
     * @param IBitManager $bits
     */
    public function __construct(IArea $area, IBitManager &$bits)
    {
        $this->area = $area;
        $this->bits =& $bits;
    }

    /**
     * Gets the area that this controller manages.
     * 
     * @return IArea
     */
    public function getArea(): IArea
    {
        return $this->area;
    }

    /**
     * Receives the BitManager, which is managed by this controller.
     * 
     * @return IBitManager
     */
    public function getBits(): IBitManager
    {
        return $this->bits;
    }

    /**
     * Gets the value in the zone controlled by this controller.
     * 
     * @return int
     */
    public function getData(): int
    {
        return $this->bits->getBitRange(
            $this->area->getRange()
        );
    }

    /**
     * Sets the value $data in the area controlled by this controller.
     * 
     * @param int $data
     * 
     * @return static
     */
    public function setData(int $data): static
    {
        $this->bits->setBitRange(
            $this->area->getRange(),
            $data
        );

        return $this;
    }

    /**
     * Changes the value in the area managed by this controller to the default value.
     * 
     * @return static
     */
    public function toDefault(): static
    {
        $this->bits->setBitRange(
            $this->area->getRange(),
            $this->area->getDefault()
        );

        return $this;
    }
}