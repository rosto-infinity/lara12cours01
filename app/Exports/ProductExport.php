<?php

namespace App\Exports;

use App\Models\Product; // -- Importe le modèle Product pour accéder aux données des produits
use Illuminate\Contracts\View\View; // -- Importe l'interface View pour définir le type de retour de la méthode view()
use Maatwebsite\Excel\Concerns\FromView; // -- Importe l'interface FromView pour permettre l'exportation de données vers Excel à partir d'une vue

class ProductExport implements FromView
{
    /**
     * Méthode view() qui retourne une vue contenant les données à exporter.
     *
     * @return View
     */
    public function view(): View
    {
        // Retourne la vue 'SuperAdmin/Products/ExcelProducts' avec les données des produits
        return view(
            'SuperAdmin/Products/ExcelProducts', // -- Chemin de la vue utilisée pour l'exportation
            [
                'products' => Product::all() // -- Récupère tous les produits depuis la base de données et les passe à la vue
            ]
        );
    }
}
