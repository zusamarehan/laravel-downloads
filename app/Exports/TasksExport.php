<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class TasksExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithTitle
{

    public $project;

    public function __construct(Collection $project)
    {
        $this->project = $project;
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
            'Project Title',
            'Tasks Title',
            'Tasks Description',
            'Tasks Due Date',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        $rows = [];

        if($row->tasks) {
            foreach($row->tasks as $relation)
            {
                $rows[] = [
                    $relation->id,
                    $row->title,
                    $relation->title,
                    $relation->desc,
                    $relation->due_date,
                    $relation->created_at,
                    $relation->updated_at,
                ];
            }

        }
        return $rows;

    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        return 'Tasks';
    }
}
