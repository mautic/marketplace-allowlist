<?php

namespace MauticPlugin\MauticCheckBundle\Helper;

class FilesHelper
{
    /**
     * @return array <string, array>
     */
    public static function getFiles(string $path): array
    {
        $list   = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $result = [
            'files' => [],
            'dirs'  => [],
        ];
        foreach ($list as $item) {
            if ($item->isDir()) {
                $result['dirs'][] = $item->getPath();
                continue;
            }
            $result['files'][] = $item->getPathname();
        }
        $result['files'] = array_unique($result['files']);
        $result['dirs']  = array_unique($result['dirs']);
        sort($result['dirs']);
        sort($result['files']);

        return $result;
    }

    public static function getLine(string $fullCode, string $partCode): int
    {
        $lines = explode(PHP_EOL, $fullCode);
        foreach ($lines as $key => $value) {
            if (false !== strpos($value, $partCode)) {
                return $key + 1;
            }
        }

        return 0;
    }

    /**
     * @return array <int>
     */
    public static function getLines(string $fullCode, string $partCode): array
    {
        $lines  = explode(PHP_EOL, $fullCode);
        $result = [];
        foreach ($lines as $key => $value) {
            if (false !== strpos($value, $partCode)) {
                $result[] = $key + 1;
            }
        }

        return $result;
    }

    public static function returnCodeLineByNumberCode(string $fullCode, int $lineNumber): string
    {
        $lines = explode(PHP_EOL, $fullCode);

        return $lines[$lineNumber - 1];
    }
}
