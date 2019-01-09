<?php declare(strict_types = 1);

namespace TownsyMush\EwwwClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use TownsyMush\Job\EwwwClient\FileJob;
use TownsyMush\Job\EwwwClient\Job;
use TownsyMush\Job\EwwwClient\WebPJob;

class Converter
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct(ClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function process(Job $job): string
    {
        if ($job instanceof FileJob) {
            return $this->processFileJob($job);
        }

        if ($job instanceof WebPJob) {
            return $this->processWebPJob($job);
        }
        throw new \Exception('Job not found');
    }

    private function processFileJob(FileJob $job)
    {
        // Get file resource
        $file = fopen($job->getPath(), 'r');
        if ($file === false) {
            throw new \Exception('Unable to open file: ' . $job->getPath());
        }

        $options = [
            [
                'name' => 'convert',
                'contents' => $job->getConvert(),
            ],
            [
                'name' => 'lossy',
                'contents' => $job->getLossy(),
            ],
            [
                'name' => 'quality',
                'contents' => $job->getQuality(),
            ],
            [
                'name' => 'metadata',
                'contents' => $job->getMetadata(),
            ],
            [
                'name' => 'file',
                'contents' => $file,
                'filename' => $job->getFileName(),
            ],
            [
                'name' => 'api_key',
                'contents' => $this->apiKey,
            ]
        ];

        $response = $this->request($options);
        if (is_resource($file)) {
            fclose($file);
        }
        return $response;
    }

    /**
     * @param $options
     * @return string
     * @throws GuzzleException
     */
    private function request($options): string
    {
        $response = $this->client->request(
            'POST',
            'https://optimize.exactlywww.com/v2/',
            [
                'multipart' => $options
            ]
        );

        return $response->getBody()->getContents();
    }

    private function processWebPJob(WebPJob $job): string
    {
        // Get file resource
        $file = fopen($job->getPath(), 'r');
        if ($file === false) {
            throw new \Exception('Unable to open file: ' . $job->getFileName());
        }

        $options = [
            [
                'name' => 'webp',
                'contents' => 1,
            ],
            [
                'name' => 'quality',
                'contents' => $job->getQuality(),
            ],
            [
                'name' => 'file',
                'contents' => $file,
                'filename' => $job->getFileName(),
            ],
            [
                'name' => 'api_key',
                'contents' => $this->apiKey,
            ]
        ];

        if ($job->getHeight() !== 0 && $job->getWidth() !== 0) {
            $options[] = [
                'name' => 'width',
                'contents' => $job->getWidth(),
            ];
            $options[] = [
                'name' => 'height',
                'contents' => $job->getHeight(),
            ];
        }

        $response = $this->request($options);
        if (is_resource($file)) {
            fclose($file);
        }
        return $response;
    }
}
