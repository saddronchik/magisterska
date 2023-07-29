<?php

namespace App\Imports;

use App\Models\references;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ReferencesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $rows)
    {

        foreach ($rows as $key  => $row) {

            if ($key == 0) {
                continue;
            }
            references::create([
                'FIO'=> $row[1],
                'email'    => $row[2],
                'telephone'    => $row[3],
                'prichinaObr'    => $row[4],
                'textObr'    => $row[5],
                'idPodr'    => $row[6],
                'status'    => $row[7],
            ]);
        }
    }
}
