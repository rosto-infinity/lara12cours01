<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
}

interface Metadata {
    last_updated: string;
}

interface Props {
    product: Product;
    metadata?: Metadata;
}

// ==================== PROPS & DATA ====================
const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Produits', href: '/products' },
    { title: 'Détail produit', href: '#' },
];

// Formatage de la date pour l'affichage
const formattedDate = props.metadata?.last_updated 
    ? new Date(props.metadata.last_updated).toLocaleDateString('fr-FR')
    : 'Non disponible';
</script>

<template>
    <Head :title="`Produit : ${props.product.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col items-center p-8">
            <div class="w-full max-w-lg rounded-xl border p-8 shadow bg-white dark:bg-gray-900">
                <h1 class="text-2xl font-bold mb-4">{{ props.product.name }}</h1>
                
                <div class="space-y-4">
                    <div>
                        <span class="font-semibold">Prix :</span>
                        <span class="ml-2">{{ props.product.price }} CFA</span>
                    </div>
                    
                    <div>
                        <span class="font-semibold">Description :</span>
                        <p class="mt-1 text-gray-600 dark:text-gray-300">{{ props.product.description }}</p>
                    </div>
                    
                    <div v-if="props.metadata">
                        <span class="font-semibold">Dernière mise à jour :</span>
                        <span class="ml-2">{{ formattedDate }}</span>
                    </div>
                </div>
            </div>
            
            <Link 
                :href="route('products.index')" 
                class="mt-6"
                prefetch
            >
                <Button variant="secondary">
                    Retour à la liste
                </Button>
            </Link>

<a
    :href="route('products.download', { product: props.product.id })"
    class="mt-4 inline-block"
    download="mon-fichier.pdf"
>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
        Télécharger PDF
    </button>
</a>




        </div>
    </AppLayout>
</template>
