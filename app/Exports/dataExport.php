<?php

namespace App\Exports;

use App\Models\downloadUsr;
use Maatwebsite\Excel\Concerns\FromCollection;


class dataExport implements FromCollection
{
    protected $sortBY;

    public function __construct( $sortBY)
    {
        $this->sortBY = $sortBY;
    }

     public function collection()
    {
        return $this->sortBY;
    }

}
