<?php

namespace E2S\Endomondo\WorkoutsDownloader;

use E2S\AbstractIntegrationTest;
use E2S\Endomondo\Api\Filter;
use E2S\Endomondo\Api\Sport;
use E2S\Endomondo\WorkoutsDownloader;

class WorkoutsDownloaderIntegrationTest extends AbstractIntegrationTest
{
    /** @var WorkoutsDownloader */
    private $downloader;

    /** @var string */
    private $dir;

    protected function setUp()
    {
        $this->dir = sprintf(
            '%s/%s',
          __DIR__.'/../resources/',
            substr(md5(mt_rand(0, 1000000000)), 0, 8)
        );

        $this->downloader = new WorkoutsDownloader(
            $this->workoutsApi(),
            $this->dir
        );
    }

    /**
     * @test
     */
    public function shouldDownloadWorkouts()
    {
        $files = $this->downloader->download(
//            new Filter(Sport::cyclingSport(), date_create('now - 1 day'))
                    new Filter(
                        Sport::cyclingTransport(),
                        null,
                        \DateTime::createFromFormat(
                            'YmdHis', '20120629150000', new \DateTimeZone('UTC')
                        )
                    )
        );

        if (!$files) {
            $this->markTestSkipped('No workouts found.');
        }

        foreach ($files as $file) {
            $this->assertFileExists($file->getPathname());
        }
    }

    protected function tearDown()
    {
        return;
        foreach (new \DirectoryIterator($this->dir) as $file) {
            if ($file->isDot()) {
                continue;
            }
            @unlink($file->getPathname());
        }
        @rmdir($this->dir);
    }
}
