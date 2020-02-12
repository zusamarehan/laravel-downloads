<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DownloadPOC implements WithMultipleSheets
{

    public $project;

    public function __construct($projects)
    {
        $this->project = $projects;
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
