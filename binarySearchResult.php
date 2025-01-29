<?php declare(strict_types=1);

namespace randomsymbols\ascfiles;

class binarySearchResult
{
    public function __construct(
        private int $low = 0,
        private int $high = 0,
        private ?int $found = null,
    ) {}

    public function isFound(): bool
    {
        return !is_null($this->found);
    }

    public function getFound(): ?int
    {
        return $this->found;
    }

    public function getLow(): int
    {
        return $this->low;
    }

    public function getHigh(): int
    {
        return $this->high;
    }
}
