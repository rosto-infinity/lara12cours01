<script setup lang="ts">
/**
 * Composant ProductList - Affiche la liste des produits avec gestion CRUD
 * 
 * Améliorations :
 * - Icônes Lucide intégrées dans les stats
 * - Meilleure organisation des imports
 * - Styles cohérents pour les cartes de stats
 */

import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import Button from '@/components/ui/button/Button.vue';
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
import { Box, Coins,CirclePlus, Eye, PencilLine, Rocket, Tags, Trash } from 'lucide-vue-next';
import { computed } from 'vue';

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

            <!-- Cartes de statistiques avec icônes -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="flex flex-col items-center justify-center p-6 rounded-xl border border-sidebar-border/70 bg-card">
                    <Box class="h-8 w-8 text-primary mb-2" />
                    <span class="text-2xl font-bold">{{ props.metadata.count }}</span>
                    <span class="text-sm text-muted-foreground">Produits</span>
                </div>

                <div class="flex flex-col items-center justify-center p-6 rounded-xl border border-sidebar-border/70 bg-card">
                    <Coins class="h-8 w-8 text-primary mb-2" />
                    <span class="text-2xl font-bold">{{ props.metadata.totalValue }} CFA</span>
                    <span class="text-sm text-muted-foreground">Valeur totale</span>
                </div>

                <div class="flex flex-col items-center justify-center p-6 rounded-xl border border-sidebar-border/70 bg-card">
                    <Tags class="h-8 w-8 text-primary mb-2" />
                    <span class="text-2xl font-bold">{{ props.metadata.categoriesCount || 0 }}</span>
                    <span class="text-sm text-muted-foreground">Catégories</span>
                </div>
            </div>

            <!-- Bouton de création -->
            <div class="flex justify-end">
                <Link href="/products/create" prefetch>
                    <Button class="gap-2">
                        <CirclePlus class="w-4 h-4" />
                        Créer un produit
                    </Button>
                </Link>


                
            </div>

            <!-- Tableau des produits -->
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
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
                                 
                                    <Link
                                        :href="`/products/${product.id}`" prefetch
                                        class="inline-flex items-center px-2 py-1 text-blue-600 hover:underline"
                                        title="Afficher"
                                    >
                                        <Eye class="w-5 h-5 mr-1" />
                                        Afficher
                                    </Link>
                                
                                <Link :href="route('products.edit', product.id)" prefetch class="flex items-center text-green-500 hover:text-green-700 transition-colors">
                                    <PencilLine class="w-4 h-4 mr-1" /> Éditer
                                </Link>
                                <button @click="handleDelete(product.id)" class="flex items-center text-red-500 hover:text-red-700 transition-colors">
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
