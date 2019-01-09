<?php declare(strict_types = 1);

namespace TownsyMush\Job\EwwwClient;

abstract class Job
{
    /**
     * @var int
     */
    private $quality = 82;

    /**
     * @var string
     */
    private $path;

    public function __construct(string $path, string $fileName = 'file')
    {
        if (empty($path)) {
            throw new \Exception('A path must be set');
        }

        $file = fopen($path, 'r');
        if ($file === false) {
            throw new \Exception('Unable to open the provided file from path: ' . $path);
        }

        fclose($file);

        $this->setFileName($fileName);
        $this->setPath($path);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    private function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): void
    {
        $this->quality = $quality;
    }
}
