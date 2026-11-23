<?php
namespace Pimple;

/**
 * Lazy service iterator.
 *
 
 */
final class ServiceIterator implements \Iterator
{
    private $container;
    private $ids;

    public function __construct(Container $container, array $ids)
    {
        $this->container = $container;
        $this->ids = $ids;
    }

    /**
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        \reset($this->ids);
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->container[\current($this->ids)];
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return \current($this->ids);
    }

    /**
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        \next($this->ids);
    }

    /**
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return null !== \key($this->ids);
    }
}
