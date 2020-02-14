<?php

namespace App\Exports;

use App\Projects;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DownloadPOC implements WithMultipleSheets
{

    /**
     * @var Collection
     */
    public $project;

    /**
     * DownloadPOC constructor.
     * @param Collection $projects
     * @param int $projectID
     */
    public function __construct(Collection $projects, int $projectID)
    {
        $this->project = $projects->where('id', $projectID);
    }

    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        return [
            new ProjectsExport($this->project),
            new CasesExport($this->project),
            new TasksExport($this->project),
            new NotesExport($this->project),
        ];
    }

}
