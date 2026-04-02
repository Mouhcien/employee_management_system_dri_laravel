<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
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
        return ['DDP','Fonction', 'Service', 'Secteur', 'DATREC',  'DATE DE MISE A LA DIPOSITION', 'DATE DE DETACHEMENT', 'DATE DE DETACHEMENT', 'Eche', 'DIPLÔME', 'ADRESSE',
            'N° CARTE COMMISSION', 'الإسم', 'الدرجة', 'المديرية الجهوية للضرائب', 'المكان', 'ADRESSE PERSONNELLE', 'TEL', 'ADRESSE EMAIL PROFESSIONNELLE', 'NOMS FR', 'PRENOMS FR', 'NOMS AR', 'PRENOMS AR'];
    }
}
