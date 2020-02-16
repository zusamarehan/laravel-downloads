<?php

namespace App\Jobs;

use App\DownloadRequests;
use App\Projects;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadPOCData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var DownloadRequests
     */
    public $downloadRequest;

    /**
     * Create a new job instance.
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

        $jobListing = [];
        // Fetch all POCs
        $allPOC = Projects::with(['cases', 'notes', 'tasks'])->get();

        // Creating New Job per Project and then pushing it to Job List Array
        foreach ($allPOC as $poc){
            array_push($jobListing, new CreateExcel($allPOC, $poc->id, $this->downloadRequest));
        }

        // Create New Job for Zipping Files and push to Job List Array
        array_push($jobListing, new ZipExcels($this->downloadRequest));
        // Create New Job for Marking Download Request as Complete
        array_push($jobListing, new FinishPOCDownload($this->downloadRequest));

        ProcessPOCDownload::withChain($jobListing)
                            ->dispatch($this->downloadRequest);

    }
}
