<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import Button from '@/components/ui/button/Button.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products List',
        href: '/products',
    },   
];

const page = usePage();
// const flash = computed(() => page.props.flash as { success?: string; })
</script>


<template>
    <Head title="Product List" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          
                <div class="bg-green-100 text-green-600 p-2 rounded-xl"
                v-if="page.props.flash?.success" >
                 {{ page.props.flash.success }}
                </div>
           
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="flex items-center justify-center relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                  <Link href="/products/create" class="absolute inset-0 flex items-center justify-center">
                  
                    <Button> Create a product</Button>
                  </Link>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
