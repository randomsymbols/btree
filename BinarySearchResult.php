<?php declare(strict_types=1);

namespace randomsymbols\ascfiles;

class BinarySearchResult
{
    /**
     * @throws BinarySearchResultException
     */
    public function __construct(
        private int $low,
        private int $high,
        private ?int $found = null,
        private bool $isFinished = false,
    ) {
        if ($low > $high) {
            throw new BinarySearchResultException('Low cannot be higher than high');
        }

        if ($this->isFound() && !$this->isFinished()) {
            throw new BinarySearchResultException('Search cannot be unfinished if result found');
        }
    }

    public function isFound(): bool
    {
        return !is_null($this->found);
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
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
