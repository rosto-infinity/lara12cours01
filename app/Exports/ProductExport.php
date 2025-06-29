<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View; // --Importe l'interface View pour le type de retour
use Maatwebsite\Excel\Concerns\FromView; // ---Importe l'interface FromView pour l'exportation Excel


class ProductExport implements FromView
{
    
    public function view(): View
    {
        return view(
            'SuperAdmin/Products/ExcelProducts',
        [
       'products' => Product::all()
        ]
        );
    }
}
