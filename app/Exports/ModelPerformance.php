<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ModelPerformance implements FromCollection, WithHeadings
{
    protected array $data;
    protected array $headings;

    /**
     * @param array $data
     */
    public function __construct(array $data, array $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection($this->data);

    }

    public function headings(): array
    {
        return $this->headings;
    }
}
