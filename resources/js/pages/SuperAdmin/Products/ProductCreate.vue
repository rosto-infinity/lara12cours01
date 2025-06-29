<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import { useForm } from '@inertiajs/vue3'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Product',
        href: '/products/create',
    },
    
];
const form = useForm({
  name: '' ,
  price:'' ,
  description: '',
})

const handleSubmit = () =>{
    form.post(route('products.store'))
}
</script>

<template>
    <Head title="Create a Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            
            <div class="relative min-h-[100vh] flex-1 p-7 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <Link :href="route('products.index')" prefetch class="flex items-center mb-4">
                    <Button class="bg-gray-400 mb-4"> Retour</Button>
                </Link> 
                <form @submit.prevent="handleSubmit" class="w-6/12 mx-auto space-y-4">
                   
                    
                    <div class="space-y-2">
                        <Label for="name"> Name</Label>
                        <Input type="text" v-model="form.name" placeholder="Product name" id="name"/>
                        <div class="text-red-400" v-if="form.errors.name">{{ form.errors.name }}</div>
                    </div>
                    
                    <div class="space-y-2">
                        <Label for="price"> Price</Label>
                        <Input type="number" v-model="form.price" placeholder="Product price" id="price"/>
                        <div class="text-red-400"  v-if="form.errors.price">{{ form.errors.price }}</div>

                    </div>
                    
                    <div class="space-y-2">
                        <Label for="description"> Description</Label>
                        <Input type="text" v-model="form.description" placeholder="Product description" id="description"/>
                        <div class="text-red-400"  v-if="form.errors.description">{{ form.errors.description }}</div>

                    </div>
                    

                    <Button :disabled="form.processing"> Add product</Button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
