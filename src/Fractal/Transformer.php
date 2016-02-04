<?php

namespace DeSmart\Adr\Fractal;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;

class Transformer
{
    /** @var Manager */
    protected $manager;

    /** @var Container */
    protected $app;

    /** @var array */
    protected $map;

    /** @var LengthAwarePaginator|null */
    protected $paginator;

    /**
     * @param Manager $manager
     * @param Container $app
     * @param array $map
     */
    public function __construct(Manager $manager, Container $app, array $map)
    {
        $this->manager = $manager;
        $this->app = $app;
        $this->map = $map;
    }

    /**
     * @param SerializerAbstract $serializer
     * @return void
     */
    public function setSerializer(SerializerAbstract $serializer)
    {
        $this->manager->setSerializer($serializer);
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @return void
     */
    public function setPaginator(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param object $item
     * @return \League\Fractal\Scope
     */
    public function transformItem($item)
    {
        $resource = new Item(
            $item,
            $this->getTransformer(get_class($item)),
            $this->getResourceName(get_class($item))
        );

        return $this->manager->createData($resource);
    }

    /**
     * @param object[] $collection
     * @return \League\Fractal\Scope
     */
    public function transformCollection($collection)
    {
        $item = reset($collection);

        $resource = new Collection(
            $collection,
            $this->getTransformer(get_class($item)),
            $this->getResourceName(get_class($item))
        );

        if (null !== $this->paginator) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($this->paginator));
        }

        return $this->manager->createData($resource);
    }

    /**
     * @return \League\Fractal\Scope
     */
    public function transformNull()
    {
        $resource = new NullResource();

        return $this->manager->createData($resource);
    }

    /**
     * @param string $className
     * @return TransformerAbstract
     * @throws \InvalidArgumentException
     */
    protected function getTransformer($className)
    {
        if (true === array_key_exists($className, $this->map)
            && true === array_key_exists('transformer', $this->map[$className])
        ) {
            return $this->app->make($this->map[$className]['transformer']);
        }

        throw new \InvalidArgumentException("Missing transformer mapping for $className.");
    }

    /**
     * @param string $className
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function getResourceName($className)
    {
        if (true === array_key_exists($className, $this->map)
            && true === array_key_exists('resource', $this->map[$className])
        ) {
            return $this->map[$className]['resource'];
        }

        throw new \InvalidArgumentException("Missing transformer mapping for $className.");
    }
}
