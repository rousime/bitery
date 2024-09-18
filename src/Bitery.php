<?php

namespace Bitery;

use Bitery\Interface\Area as IArea;
use Bitery\Interface\BitManager as IBitManager;
use Bitery\Interface\AreaCollection as IAreaCollection;
use ValueError;
use Stringable;
use IteratorAggregate;
use Traversable;

use function is_string;
use function sprintf;


class Bitery implements Stringable, IteratorAggregate
{
    /**
     * @var IAreaCollection
     */
    protected IAreaCollection $areas;

    /**
     * @var IBitManager
     */
    protected IBitManager $bits;

    /**
     * @param IAreaCollection|null $areas
     * @param IBitManager|string $bits
     */
    public function __construct(?IAreaCollection $areas = null, IBitManager|string $bits = "")
    {
        if (!isset($areas))
        {
            $areas = new AreaCollection;
        }

        if (is_string($bits))
        {
            $bits = new BitManager($bits);
        }

        $this->withCollection($areas)
            ->withBits($bits);
    }

    /**
     * Gets the controller for the area with the key $key.
     * 
     * @param string $key
     * 
     * @return Controller
     * 
     * @throws ValueError if there is no area with this key
     */
    public function getController(string $key): Controller
    {
        if ($area = $this->areas->getArea($key))
        {
            return $this->toController($area);
        }

        throw new ValueError(sprintf('Unknown area key: "%s"', $key));
    }

    /**
     * Sets all areas to their default values.
     * 
     * @return static
     */
    public function toDefaults(): static
    {
        foreach($this as $controller)
        {
            $controller->toDefault();
        }

        return $this;
    }

    /**
     * Retrieves data from all areas and returns it as an associative array.
     * 
     * @return array
     */
    public function getData(): array
    {
        $result = [];

        foreach($this as $controller)
        {
            $result[
                $controller->getArea()->getKey()
            ] = $controller->getData();
        }

        return $result;
    }

    /**
     * Changes the BitManager, which is managed by this class.
     * 
     * @param IBitManager $bits
     * 
     * @return static
     */
    public function withBits(IBitManager $bits): static
    {
        $this->bits = $bits;

        return $this;
    }

    /**
     * Receives the BitManager, which is managed by this class.
     * 
     * @return IBitManager
     */
    public function getBits(): IBitManager
    {
        return $this->bits;
    }

    /**
     * Changes the collection of areas managed by this class.
     * 
     * @param IAreaCollection $collection
     * 
     * @return static
     */
    public function withCollection(IAreaCollection $collection): static
    {
        $this->areas = $collection;

        return $this;
    }

    /**
     * Retrieves the collection of areas managed by this class.
     * 
     * @return IAreaCollection
     */
    public function getCollection(): IAreaCollection
    {
        return $this->areas;
    }

    /**
     * {@inheritdoc}
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->bits->getString();
    }

    /**
     * Returns a controller for each area.
     * 
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        foreach($this->areas as $area)
        {
            yield $this->toController($area);
        }
    }

    protected function toController(IArea &$area): Controller
    {
        return new Controller(
            $area,
            $this->bits
        );
    }
}