<?php declare(strict_types = 1);

namespace TownsyMush\EwwwClient\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use TownsyMush\EwwwClient\Converter;
use TownsyMush\Job\EwwwClient\FileJob;
use TownsyMush\Job\EwwwClient\WebPJob;

final class ConverterTest extends TestCase
{
    private $inputPath = __DIR__ . '/data/myfile.jpg';

    /** @var Converter */
    private $converter;

    public function setUp(): void
    {
        parent::setUp();
        $client = new Client();
        $this->converter = new Converter($client, 'YWHErzAFyvEAQQuG3DGv6j9Rg9iVQWXE');
    }

    public function testConverterUsingFileJob()
    {
        $fileJob = new FileJob($this->inputPath);
        $fileJob->setLossy(true);
        $fileJob->setConvert(true);
        $output = $this->converter->process($fileJob);
        file_put_contents(__DIR__ . '/data/output/convertfile.png', $output);
        $this->assertLessThan(filesize($this->inputPath), filesize(__DIR__ . '/data/output/convertfile.png'));
    }

    public function testConverterUsingWebPJob()
    {
        $webPJob = new WebPJob($this->inputPath);
        $output = $this->converter->process($webPJob);
        file_put_contents(__DIR__ . '/data/output/webp.webp', $output);
        $this->assertLessThan(filesize($this->inputPath), filesize(__DIR__ . '/data/output/webp.webp'));
    }

    public function testConverterUsingFileAndWebPJob()
    {
        $fileJob = new FileJob($this->inputPath);
        $fileJob->setLossy(true);
        $fileJob->setConvert(true);
        $output = $this->converter->process($fileJob);
        file_put_contents(__DIR__ . '/data/output/convertfile.png', $output);

        $webPJob = new WebPJob(__DIR__ . '/data/output/convertfile.png');
        $output = $this->converter->process($webPJob);
        file_put_contents(__DIR__ . '/data/output/webp.webp', $output);

        $this->assertLessThan(filesize($this->inputPath), filesize(__DIR__ . '/data/output/webp.webp'));
    }
}
