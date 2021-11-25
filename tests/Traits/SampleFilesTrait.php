<?php

namespace Tests\Traits;

use Illuminate\Http\UploadedFile;

trait SampleFilesTrait
{
    protected static string $filePath = __DIR__ . DIRECTORY_SEPARATOR . 'stuffs';

    /**
     * Return the path for the file
     * @param string $file
     * @return string
     */
    protected function getPath(string $file): string
    {
        return self::$filePath . DIRECTORY_SEPARATOR . $file;
    }

    /**
     * Return a file content as a string
     * @param string $file
     * @return string
     */
    protected function getContent(string $file): string
    {
        return file_get_contents($this->getPath($file));
    }

    /**
     * Return the UploadedFile fake object based on the string passed
     * @param string $file
     * @return UploadedFile
     */
    protected function getUploadedFake(string $file): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($file, $this->getContent($file));
    }

    protected function getIncludeArray(string $file): array
    {
        return require_once $this->getPath($file);
    }
}
