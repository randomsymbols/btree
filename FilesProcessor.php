<?php declare(strict_types=1);

namespace randomsymbols\ascfiles;

use SplFileObject;

class FilesProcessor {
    private const FLUSH_LINES_COUNT = 200;

    /**
     * @throws BinarySearchResultException
     */
    public function filesDiff(
        string $checkFileName,
        string $blackListFileName,
        string $outputFileName,
    ) {
        $checkFile = new SplFileObject($checkFileName);
        $blackListFile = new SplFileObject($blackListFileName);
        $outputFile = new SplFileObject($outputFileName, 'a');

        $blackListFile->seek(PHP_INT_MAX);
        $blackListFileLinesCount = $blackListFile->key();

        while (!$checkFile->eof()) {
            $string = trim($checkFile->fgets());
            $low = 0;
            $high = $blackListFileLinesCount;

            do {
                $result = $this->binarySearch($string, $blackListFile, low: $low, high: $high);
                $low = $result->getLow();
                $high = $result->getHigh();
            } while (
                !$result->isFinished() &&
                !$result->isFound()
            );

            if (!$result->isFound()) {
                $outputFile->fwrite(PHP_EOL . $string);

                if ($checkFile->key() % self::FLUSH_LINES_COUNT == 0) {
                    $outputFile->fflush();
                }
            }
        }
    }

    /**
     * @throws BinarySearchResultException
     */
    private function binarySearch(
        string $string,
        SplFileObject $file,
        int $low,
        int $high,
    ): BinarySearchResult
    {
        $middle = (int) ceil(($low + $high)/2);
        $file->seek($middle);
        $value = trim($file->current());

        $decrement = $middle == $low ? 0 : 1;
        $increment = $middle == $high ? 0 : 1;

        return match (true) {
            $value == $string => new BinarySearchResult(
                low: $low,
                high: $high,
                found: $file->key(),
                isFinished: true,
            ),

            $low == $high => new BinarySearchResult(
                low: $low,
                high: $high,
                found: null,
                isFinished: true,
            ),

            $string < $value => new BinarySearchResult(
                low: $low,
                high: $middle - $decrement,
                found: null,
                isFinished: false,
            ),

            $string > $value => new BinarySearchResult(
                low: $middle + $increment,
                high: $high,
                found: null,
                isFinished: false,
            ),
        };
    }
}
