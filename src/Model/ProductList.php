<?php

namespace App\Model;

class ProductList
{
    /**
     * @var ProductItem[]
     */
    private array $items;

    /**
     * @param ProductItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return ProductItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ProductItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }
}
