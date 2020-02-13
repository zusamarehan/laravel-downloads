<?php

namespace App\Jobs;

use App\DownloadPOC\StoreExcels;
use App\DownloadPOC\ZipExcels;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Routing\Pipeline;

class DownloadPOCData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Collection
     */
    private $project;

    /**
     * Create a new job instance.
     *
     * @param Collection $project
     */
    public function __construct(Collection $project)
    {
        //
        $this->project = $project;
    }

    /**
     * @return array
     */
    public function loadPipes() {

        return [
            StoreExcels::class,
            ZipExcels::class
        ];

    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $pipeline = app(Pipeline::class);

        $pipeline->send($this->project)
            ->through(self::loadPipes())
            ->then(function(){
                logger('Download Ready');
             });

    }
}
