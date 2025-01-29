<?php declare(strict_types=1);

include_once 'FilesProcessor.php';
include_once 'BinarySearchResult.php';

use randomsymbols\ascfiles\FilesProcessor;

$filesProcessor = new FilesProcessor();
$filesProcessor->filesDiff('file1.txt', 'file2.txt', 'file3.txt');
$filesProcessor->filesDiff('file2.txt', 'file1.txt', 'file4.txt');
