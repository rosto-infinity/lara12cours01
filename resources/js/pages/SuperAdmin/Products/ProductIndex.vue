<script setup lang="ts">
/**
 * Composant ProductList - Affiche la liste des produits avec gestion CRUD
 * 
 * Fonctionnalités :
 * - Affichage tabulaire des produits
 * - Messages flash (succès/erreur)
 * - Actions : Édition/Suppression
 * - Responsive design (Tailwind CSS)
 * 
 * Technologies :
 * - Vue 3 + Composition API
 * - TypeScript
 * - InertiaJS (routing)
 * - ShadCN/ui (composants stylisés)
 * - Lucide (icônes)
 */

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { computed } from 'vue';
import { Rocket, PencilLine,Trash, } from 'lucide-vue-next'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'


// ===================== TYPAGE ====================
interface FlashMessage {
    success?: string;
    error?: string;
    // Ajoutez d'autres types de messages si nécessaire
}
interface Product {
    id: number,
    name: string,
    price: number,
    description: string,
}

interface props {
    products: Product[];
}

// ==================== -PROPS & DATA ====================
const props = defineProps<props>()

/**
 * -Configuration du fil d'Ariane
 * @type {BreadcrumbItem[]}
 */
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products List',
        href: '/products',
    },
];

/**
 * -Gestion des messages flash
 * @computed
 */
const page = usePage();
const flash = computed<FlashMessage>(() => page.props.flash as FlashMessage);



</script>

<template>
<!-- -Métadonnées SEO -->
    <Head title="Product List" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- Message flash typé -->

            <Alert v-if="flash.success" class="bg-green-100 text-green-600">
                <Rocket class="h-4 w-4" />
                <AlertTitle>Notification</AlertTitle>
                <AlertDescription>
                    {{ flash.success }}
                </AlertDescription>
            </Alert>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="flex items-center justify-center relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    01
                </div>

                <!-- Espaces réservés -->
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    02
                </div>

                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    03
                </div>
            </div>

            <div>
                <Link href="/products/create" prefetch class="">
                <Button>Create a product</Button>
                </Link>
            </div>

            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div>

            <!-- Tableau des produits -->
                    <Table>
                        <TableCaption>A list of your recent products.</TableCaption>
                        <TableHeader>
                            <TableRow class="text-black text-bold font-bold bg-gray-100" >
                                <TableHead>#ID</TableHead>
                                <TableHead class="w-[120px]">
                                    Name
                                </TableHead>
                                <TableHead>Price</TableHead>
                                <TableHead>Description</TableHead>
                                <TableHead class="text-center">
                                    Actions
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="product in products" :key="product.id">
                                <TableCell> {{ product.id }}</TableCell>
                                <TableCell class="font-medium">
                                    {{ product.name }}
                                </TableCell>
                                <TableCell> {{ product.price }} CFA</TableCell>
                                <TableCell> {{ product.description }}</TableCell>
                                <TableCell class=" flex text-right space-x-2">
                                    <Link :href="route('products.edit', product.id)" prefetch class="">
                                      <div class="flex text-green-500 hover:text-green-700">
                                          <PencilLine class=" w-4 h-4"/> Edit
                                    </div>
                                         
                                    </Link>
                                    <Link :href="route('products.destroy', product.id)" prefetch class="">
                                    <div class="flex text-red-500 hover:text-red-700">
                                        <Trash class=" w-4 h-4"/> Delete
                                    </div>
                                    
                                    </Link>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
