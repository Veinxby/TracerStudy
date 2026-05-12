<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\Sheets\PermintaanSheet;
use App\Imports\Sheets\KandidatSheet;
use App\Imports\Sheets\InterviewSheet;

class PermintaanImport implements WithMultipleSheets
{
    public $permintaanMap = [];
    public $detailMap = [];

    public function sheets(): array
    {
        return [
            'permintaan' => new PermintaanSheet($this->permintaanMap),
            'kandidat'   => new KandidatSheet($this->permintaanMap, $this->detailMap),
            'interview'  => new InterviewSheet($this->permintaanMap, $this->detailMap),
        ];
    }
}
