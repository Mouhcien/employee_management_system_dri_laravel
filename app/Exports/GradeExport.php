<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GradeExport implements FromCollection, WithHeadings
{
    protected array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
        return ['#', 'Grade','Niveau', 'PPR', 'CIN', 'NOMS FR', 'PRENOMS FR', 'NOMS AR', 'PRENOMS AR', 'ADRESSE EMAIL PROFESSIONNELLE', 'Service', 'Entité', 'Secteur/Section'];
    }
}
