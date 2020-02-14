<?php

namespace App\Jobs;

use App\DownloadRequests;
use App\Exports\DownloadPOC;
use App\Projects;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class CreateExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Projects
     */
    private $projects;
    /**
     * @var DownloadRequests
     */
    private $downloadRequests;
    /**
     * @var int
     */
    private $projectID;


    /**
     * Create a new job instance.
     *
     * @param Collection $projects
     * @param int $projectID
     * @param DownloadRequests $downloadRequests
     */
    public function __construct(Collection $projects, int $projectID, DownloadRequests $downloadRequests)
    {
        //
        $this->projects = $projects;
        $this->downloadRequests = $downloadRequests;
        $this->projectID = $projectID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Excel::store(new DownloadPOC($this->projects, $this->projectID), $this->downloadRequests->id.'/'.$this->projectID.'.xlsx', 'exports');

        DownloadRequests::find($this->downloadRequests->id)
            ->update([
                'percentage'   => ($this->projectID/count($this->projects)) * 100,
            ]);

    }
}
