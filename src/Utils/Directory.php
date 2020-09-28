<?php

namespace App\Utils;

class Directory
{
    /**
     * Возвращает список всех файдлов (SplFileInfo)
     * включаявложенные внутри директории.
     *
     * @param $dirPath
     *
     * @return \SplFileInfo[]
     */
    public static function scan(string $dirPath): array
    {
        if (!is_dir($dirPath)) {
            throw new \InvalidArgumentException("Каталог не существует dirPath : {$dirPath}");
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $dirPath, \RecursiveDirectoryIterator::SKIP_DOTS
            ),
        );

        return iterator_to_array($iterator, false);
    }
}