<?php declare(strict_types = 1);

namespace TownsyMush\Job\EwwwClient;

abstract class Job
{
    private $fileName = 'file';

    private $quality = 82;

    private $outputPath = '';
    /**
     * Get file path
     * @return mixed
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    public function setOutputPath(string $outputPath): self
    {
        $this->outputPath = $outputPath;

        return $this;
    }
}
