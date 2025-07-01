<script setup lang="ts">
/**
 * Composant ProductList - Affiche la liste des produits avec gestion CRUD
 * 
 * Améliorations :
 * - Icônes Lucide intégrées dans les stats
 * - Meilleure organisation des imports
 * - Styles cohérents pour les cartes de stats
 */
import { Download } from 'lucide-vue-next';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';

import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,

} from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Box, Coins, CirclePlus, Eye, PencilLine, Rocket, Tags, Trash, TriangleAlert, } from 'lucide-vue-next';
import { computed } from 'vue';
import { router } from '@inertiajs/vue3'
// ===================== TYPAGE ====================
interface FlashMessage {
    success?: string;
    error?: string;
}

interface Product {
    id: number,
    name: string,
    price: number,
    description: string
}

interface Props {
    products: Product[];
    metadata: {
        count: number;
        totalValue?: number;
        categoriesCount?: number; // Nouvelle métrique
    };
}

// ==================== PROPS & DATA ====================
const props = defineProps<Props>()
const page = usePage();
const flash = computed<FlashMessage>(() => page.props.flash as FlashMessage);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Products List', href: '/products' }
];

const handleDelete = (productId: number) => {
    if (!confirm('Voulez-vous vraiment supprimer ce produit ?')) return;
    useForm({}).delete(route('products.destroy', productId));
};


const form = useForm({
    import_file: null
})

const handleFileChange = (e) => {
    form.import_file = e.target.files[0]
}

const handleSubmit = () => {
    form.post(route('products.import.excel.data'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
           router.reload({ only: ['products', 'metadata'] })
        },
        onError: (errors) => {
            if (errors.import_file) {
                form.reset('import_file')
            }
        }
    })
}




</script>

<template>

    <Head title="Product List" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- Messages flash -->
            <Alert v-if="flash.success" class="bg-green-100 text-green-600">
                <Rocket class="h-4 w-4" />
                <AlertTitle>Notification</AlertTitle>
                <AlertDescription>{{ flash.success }}</AlertDescription>
            </Alert>
<Alert 
    v-if="Object.keys($page.props.errors).length > 0" 
    class="bg-red-100 text-red-600"
>
    <TriangleAlert class="h-4 w-4" />
    <AlertTitle>Erreurs d'importation</AlertTitle>
    <AlertDescription>
        <ul>
            <li v-for="(error, line) in $page.props.errors" :key="line">
                <strong>{{ line }}:</strong> {{ error }}
            </li>
        </ul>
    </AlertDescription>
</Alert>

            <Alert v-if="form.errors.import_file" class="bg-red-100 text-red-600">
                <TriangleAlert class="h-10 w-10" />
                <AlertTitle>Notification</AlertTitle>
                <AlertDescription>{{ form.errors.import_file }}</AlertDescription>
            </Alert>
            <!-- <div class="text-red-400" v-if="form.errors.import_file">{{ form.errors.import_file }}</div> -->
            <!-- Cartes de statistiques avec icônes -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="flex flex-col items-center justify-center p-6 rounded-xl border border-sidebar-border/70 bg-card">
                    <Box class="h-8 w-8 text-primary mb-2" />
                    <span class="text-2xl font-bold">{{ props.metadata.count }}</span>
                    <span class="text-sm text-muted-foreground">Produits</span>
                </div>

                <div
                    class="flex flex-col items-center justify-center p-6 rounded-xl border border-sidebar-border/70 bg-card">
                    <Coins class="h-8 w-8 text-primary mb-2" />
                    <span class="text-2xl font-bold">{{ props.metadata.totalValue }} CFA</span>
                    <span class="text-sm text-muted-foreground">Valeur totale</span>
                </div>

                <div
                    class="flex flex-col items-center justify-center p-6 rounded-xl border border-sidebar-border/70 bg-card">
                    <Tags class="h-8 w-8 text-primary mb-2" />
                    <span class="text-2xl font-bold">{{ props.metadata.categoriesCount || 0 }}</span>
                    <span class="text-sm text-muted-foreground">Catégories</span>
                </div>
            </div>

            <!-- Bouton de création + Téléchargement PDF -->
            <div class="flex justify-end gap-4">

<form @submit.prevent="handleSubmit" class="space-y-4" enctype="multipart/form-data">
    <div class="flex flex-col gap-3">
       

        <div class="flex items-center gap-3">
            <input
                type="file"
                name="import_file"
                @change="handleFileChange"
                accept=".xlsx,.xls,.csv"
                class="file:px-4 file:py-2 file:border file:border-green-300 file:rounded file:text-sm file:font-medium file:bg-white file:text-gray-700 hover:file:bg-gray-50"
               
            />

            <button
                type="submit"
                class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors disabled:opacity-50"
                :disabled="form.processing"
            >
                <template v-if="form.processing">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <template v-else>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Importer
                </template>
            </button>
        </div>
    </div>
</form>





                <a :href="route('products.downloadAll')"
                    class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded hover:bg-green-700 transition-colors">
                    <Download class="w-5 h-5" />
                    Exporter tous les produits (PDF)
                </a>

                <a :href="route('products.excel')"
                    class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded hover:bg-green-700 transition-colors">
                    <Download class="w-5 h-5" />
                    Exporter tous les produits (Excel)
                </a>

                <Link :href="route('products.create')" prefetch>
                <span
                    class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded hover:bg-green-700 transition-colors">
                    <CirclePlus class="w-4 h-4" />
                    Créer un produit
                </span>
                </Link>
            </div>

            <!-- Tableau des produits -->
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <Table>
                    <TableCaption>Liste de vos produits récents</TableCaption>
                    <TableHeader>
                        <TableRow class="text-black font-bold ">
                            <TableHead>#ID</TableHead>
                            <TableHead>Nom</TableHead>
                            <TableHead>Prix</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="product in products" :key="product.id">
                            <TableCell>{{ product.id }}</TableCell>
                            <TableCell class="font-medium">{{ product.name }}</TableCell>
                            <TableCell>{{ product.price }} CFA</TableCell>
                            <TableCell class="max-w-[200px] truncate">{{ product.description }}</TableCell>
                            <TableCell class="flex justify-end space-x-2">

                                <Link :href="`/products/${product.id}`" prefetch
                                    class="inline-flex items-center px-2 py-1 text-blue-600 hover:underline"
                                    title="Afficher">
                                <Eye class="w-5 h-5 mr-1" />
                                Afficher
                                </Link>

                                <Link :href="route('products.edit', product.id)" prefetch
                                    class="flex items-center text-green-500 hover:text-green-700 transition-colors">
                                <PencilLine class="w-4 h-4 mr-1" /> Éditer
                                </Link>
                                <button @click="handleDelete(product.id)"
                                    class="flex items-center text-red-500 hover:text-red-700 transition-colors">
                                    <Trash class="w-4 h-4 mr-1" /> Supprimer
                                </button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
