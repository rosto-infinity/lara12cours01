<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
}

interface Props {
    product: Product;
}

const props = defineProps<Props>();
</script>

<template>
    <Head :title="`Fiche Produit - ${props.product.name}`" />
    
    <div class="p-8 font-sans">
        <!-- En-tête du PDF -->
        <div class="text-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800">Fiche Technique du Produit</h1>
            <p class="text-gray-600">Généré le {{ new Date().toLocaleDateString('fr-FR') }}</p>
        </div>

        <!-- Détails du produit -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ props.product.name }}</h2>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Référence</p>
                        <p class="font-semibold">PROD-{{ props.product.id.toString().padStart(4, '0') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Prix</p>
                        <p class="font-semibold">{{ props.product.price }} CFA</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm font-medium text-gray-500">Description</p>
                    <p class="text-gray-700 whitespace-pre-line">{{ props.product.description }}</p>
                </div>

                <!-- Pied de page -->
                <div class="mt-8 pt-4 border-t text-xs text-gray-500">
                    <p>© {{ new Date().getFullYear() }} Votre Entreprise - Tous droits réservés</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Styles optimisés pour l'impression PDF */
@page {
    margin: 1cm;
    size: A4;
}

body {
    font-family: 'Helvetica', 'Arial', sans-serif;
    line-height: 1.6;
    color: #333;
}

/* Empêcher les sauts de page à l'intérieur des blocs importants */
.no-break {
    page-break-inside: avoid;
}
</style>
