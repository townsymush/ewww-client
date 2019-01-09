<?php declare(strict_types = 1);

namespace TownsyMush\Job\EwwwClient;

class FileJob extends Job
{
    private $metadata = 0;

    private $lossy = 0;

    private $convert = 0;

    public function setMetadata(bool $metadata): void
    {
        $this->metadata = (int) $metadata;
    }

    public function getMetadata(): int
    {
        return $this->metadata;
    }

    public function setLossy(bool $lossy): void
    {
        $this->lossy = (int) $lossy;
    }

    public function getLossy(): int
    {
        return $this->lossy;
    }

    public function getConvert(): int
    {
        return $this->convert;
    }

    public function setConvert(bool $convert): void
    {
        $this->convert = (int) $convert;
    }
}
