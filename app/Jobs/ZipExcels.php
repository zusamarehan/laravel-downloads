<?php

namespace App\Jobs;

use App\DownloadRequests;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ZipExcels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var DownloadRequests
     */
    private $downloadRequests;

    /**
     * Create a new job instance.
     *
     * @param DownloadRequests $downloadRequests
     */
    public function __construct(DownloadRequests $downloadRequests)
    {
        //
        $this->downloadRequests = $downloadRequests;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        // Name of the archive to download
        $zipFile = $this->downloadRequests->id.'.zip';

        // Initializing PHP class
        $zip = new \ZipArchive();
        $zip->open(storage_path('app/public/poc/'.$zipFile), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        // get all the POC Data Excels files for the Organization
        $projectExcels = Storage::disk('exports')->files($this->downloadRequests->id);

        foreach ($projectExcels as $projectExcel){
            dump($projectExcels);
            // Adding file: second parameter is what will the path inside of the archive
            // So it will create another folder called "storage/" inside ZIP, and put the file there.
            $zip->addFile(storage_path('app/public/poc/').$projectExcel, $projectExcel);

        }

        $zip->close();
    }
}
