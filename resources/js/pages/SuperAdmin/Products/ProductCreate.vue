<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Product',
        href: '/products/create',
    },
    
];
</script>

<template>
    <Head title="Create a Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            
            <div class="relative min-h-[100vh] flex-1 p-7 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <form action="" class="w-4/12 mx-auto space-y-4">
                    
                    <div class="space-y-2">
                        <Label for="name"> Name</Label>
                        <Input type="text" placeholder="Product name" id="name"/>
                    </div>
                    
                    <div class="space-y-2">
                        <Label for="price"> Name</Label>
                        <Input type="number" placeholder="Product price" id="price"/>
                    </div>
                    
                    <div class="space-y-">
                        <Label for="description"> Description</Label>
                        <Input type="text" placeholder="Product description" id="description"/>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
