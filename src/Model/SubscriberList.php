<?php

namespace App\Model;

class SubscriberList
{
    /**
     * @var SubscriberItem[]
     */
    private array $items;

    /**
     * @param SubscriberItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return SubscriberItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param SubscriberItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }
}
