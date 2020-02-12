<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProjectsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    public $project;

    public function __construct(Collection $projects)
    {
        $this->project = $projects;
    }

    /**
    * @return Collection
    */
    public function collection()
    {
        return $this->project;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '#',
            'Title',
            'Description',
            'Start Date',
            'End Date',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        return 'POC Lists';
    }
}
