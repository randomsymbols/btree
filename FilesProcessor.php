<?php declare(strict_types=1);

namespace randomsymbols\ascfiles;

use SplFileObject;

class FilesProcessor {
    public function filesDiff(
        string $checkFileName,
        string $blackListFileName,
        string $outputFileName,
    ) {
        $checkFile = new SplFileObject($checkFileName);
        $blackListFile = new SplFileObject($blackListFileName);
        $outputFile = new SplFileObject($outputFileName, 'a');

        while (!$checkFile->eof()) {
            $string = trim($checkFile->fgets());
            $blackListFile->seek(PHP_INT_MAX);
            $linesCount = $blackListFile->key();

            $result = $this->binarySearch($string, $blackListFile, low: 0, high: $linesCount);

            if (!$result->isFound()) {
                $outputFile->fwrite(PHP_EOL . $string);
                $outputFile->fflush();
            }
        }
    }

    private function binarySearch(
        string $string,
        SplFileObject $file,
        int $low,
        int $high,
    ): binarySearchResult
    {
        $middle = (int) ceil(($low + $high)/2);
        $file->seek($middle);
        $value = trim($file->current());

        return match (true) {
            $value === $string => new BinarySearchResult(found: $file->key()),
            $high == $low => new binarySearchResult(found: null),
            $string < $value => $this->binarySearch($string, $file, low: $low, high: $middle - 1),
            $string > $value => $this->binarySearch($string, $file, low: $middle + 1, high: $high),
        };
    }
}
