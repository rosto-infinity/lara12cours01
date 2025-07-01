<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ProductsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $validator = Validator::make([], []); // Initialisation
        $errors = [];
        $existingNames = Product::pluck('name')->toArray();

        foreach ($rows as $index => $row) {
            // Validation des données
            $rowValidator = Validator::make([
                'name' => $row[0],
                'price' => $row[1]
            ], [
                'name' => 'required|string|max:25|unique:products,name',
                'price' => 'required|numeric'
            ]);

            if ($rowValidator->fails()) {
                foreach ($rowValidator->errors()->all() as $message) {
                    $errors["Ligne {$index}"] = $message;
                }
                continue;
            }

            // Vérification des doublons dans le fichier
            if (in_array($row[0], $existingNames)) {
                $errors["Ligne {$index}"] = "Le nom '{$row[0]}' existe déjà dans la base de données";
                continue;
            }

            Product::create([
                'name' => $row[0],
                'price' => (float)$row[1],
                'description' => $row[2] ?? '',
            ]);

            $existingNames[] = $row[0]; // Mise à jour des noms existants
        }

        if (!empty($errors)) {
            $validator->errors()->merge($errors);
            throw new ValidationException($validator);
        }
    }
}
