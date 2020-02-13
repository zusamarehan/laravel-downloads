<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProjectsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithMapping
{

    /**
     * @var Collection
     */
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

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->title,
            $row->desc,
            $row->start_date,
            $row->end_date,
            $row->created_at,
            $row->updated_at
        ];
    }
}
