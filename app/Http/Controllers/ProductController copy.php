<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * -Affiche la liste des produits (avec pagination)
     */
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

    /**
     * -Affiche le formulaire de création
     */
    public function create()
    {
        return Inertia::render('SuperAdmin/Products/ProductCreate');
    }

    /**
     * -Enregistre un nouveau produit (avec transaction)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            Product::create($validated);
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit créé avec succès');
    }

    /**
     * -Affiche un produit spécifique
     */

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



    /**
     * -Affiche le formulaire d'édition
     */
    public function edit(Product $product)
    {
        return Inertia::render('SuperAdmin/Products/ProductEdit', [
            'product' => $product
        ]);
    }

    /**
     * -Met à jour un produit existant
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'description' => 'sometimes|string',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit mis à jour avec succès');
    }

    /**
     * -Supprime un produit (avec gestion des erreurs)
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return back()->with('success', 'Produit supprimé avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression');
        }
    }



 public function download(Product $product)
 {
     $filename = "Fiche_Produit_{$product->name}_".now()->format('YmdHis').'.pdf';
    
     return Pdf::loadView('SuperAdmin/Products/PdfProduct', compact('product'))
         ->download($filename);
}


}



