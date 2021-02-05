<?php

declare(strict_types=1);

namespace Sura\Sitemap;

class FileSystem implements IFileSystem
{
    public function file_get_contents($filepath)
    {
        return file_get_contents($filepath);
    }

    public function file_put_contents($filepath, $content)
    {
        return file_put_contents($filepath, $content);
    }

    public function gzopen($filepath, $mode)
    {
        return gzopen($filepath, $mode);
    }

    public function gzwrite($file, $content)
    {
        return gzwrite($file, $content);
    }

    public function gzclose($file)
    {
        return gzclose($file);
    }

    public function file_exists($filepath)
    {
        return file_exists($filepath);
    }
}
