<?php

namespace App\Jobs;

use App\DownloadRequests;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FinishPOCDownload implements ShouldQueue
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
        DownloadRequests::find($this->downloadRequest->id)
            ->update([
                'percentage'   => 100,
                'end_time'     => Carbon::now(),
                'download_url' => '/exports/'.$this->downloadRequest->id
            ]);
    }
}
