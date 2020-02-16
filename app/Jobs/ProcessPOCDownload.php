<?php

namespace App\Jobs;

use App\DownloadRequests;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessPOCDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var DownloadRequests
     */
    private $downloadRequest;

    /**
     * Create a new job instance.
     *
     * @param DownloadRequests $downloadRequest
     */
    public function __construct(DownloadRequests $downloadRequest)
    {
        //
        $this->downloadRequest = $downloadRequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Storage::disk('exports')->makeDirectory($this->downloadRequest->id);
    }
}
