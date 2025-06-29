<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    // Constantes pour la pagination
    private const PER_PAGE = 15;

    public function index()
    {
       $products = Product::latest()->get();

        return Inertia::render('SuperAdmin/Products/ProductIndex', [
            'products' => $products,
            'metadata' => [
                'count' => $products->count(), // Utilisation de la collection déjà chargée
                'totalValue' => $products->sum('price')
                
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('SuperAdmin/Products/ProductCreate', [
            'defaultValues' => [
                'price' => 0,
                'description' => ''
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25|unique:products,name',
            'price' => 'required|numeric|min:0|max:999999',
            'description' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($validated) {
            Product::create($validated);
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit créé avec succès');
    }

    public function show(Product $product)
    {
        $productData = $product->only(['id', 'name', 'price', 'description']);

        return Inertia::render('SuperAdmin/Products/ProductShow', [
            'product' => $productData,
            'metadata' => [
                'last_updated' => $product->updated_at->format('Y-m-d H:i'),
            ]
        ]);
    }

    public function edit(Product $product)
    {
        return Inertia::render('SuperAdmin/Products/ProductEdit', [
            'product' => $product->only(['id', 'name', 'price', 'description'])
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25|unique:products,name,'.$product->id,
            'price' => 'required|numeric|min:0|max:999999',
            'description' => 'required|string|max:1000',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit mis à jour avec succès');
    }

    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->delete();
        });

        return back()->with('success', 'Produit supprimé avec succès');
    }

    public function download(Product $product)
    {
        $filename = "Fiche_Produit_{$product->name}_".now()->format('YmdHis').'.pdf';
        
        return Pdf::loadView('SuperAdmin/Products/PdfProduct', [
            'product' => $product,
            'date' => now()->format('d/m/Y')
        ])->download($filename);
    }

    public function downloadAll()
{
    $products = Product::latest()->get();
    $filename = "Inventaire_Produits_".now()->format('YmdHis').'.pdf';
    
    return Pdf::loadView('SuperAdmin/Products/PdfAllProducts', [
        'products' => $products,
        'date' => now()->format('d/m/Y'),
        'totalValue' => $products->sum('price')
    ])->download($filename);
}
public function excel()
    {
        // --Génère un nom de fichier basé sur la date et l'heure actuelles
        $fileName = now()->format('d-m-Y H.i.s');
        
        //-- Télécharge le fichier Excel avec les données d'historique des emplois
        return Excel::download(new ProductExport, 'Products_' . $fileName . '.xlsx');
    }
}
