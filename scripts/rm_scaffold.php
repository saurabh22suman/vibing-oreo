<?php
$root = __DIR__ . '/../scaffold';
if (is_dir($root)) {
    $it = new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($root);
    echo "scaffold removed\n";
} else {
    echo "scaffold not found\n";
}
$index = __DIR__ . '/../index.html';
if (file_exists($index)) {
    unlink($index);
    echo "index.html removed\n";
} else {
    echo "index.html not found\n";
}
