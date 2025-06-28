<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{
  product: {
    id: number
    name: string
    price: number
    description: string
  }
}>()

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Produits', href: '/products' },
  { title: 'Détail produit', href: '#' },
]
</script>

<template>
  <Head :title="`Produit : ${product.name}`" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col items-center p-8">
      <div class="w-full max-w-lg rounded-xl border p-8 shadow bg-white dark:bg-gray-900">
        <h1 class="text-2xl font-bold mb-4">{{ product.name }}</h1>
        <div class="mb-2">
          <span class="font-semibold">Prix :</span>
          <span>{{ product.price }} €</span>
        </div>
        <div class="mb-2">
          <span class="font-semibold">Description :</span>
          <span>{{ product.description }}</span>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
