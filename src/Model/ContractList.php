<?php

namespace App\Model;

class ContractList
{
    /**
     * @var ContractItem[]
     */
    private array $items;

    /**
     * @param ContractItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return ContractItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ContractItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }
}
