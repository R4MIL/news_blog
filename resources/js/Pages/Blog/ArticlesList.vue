<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    articles: Array
});

</script>

<template>
    <Head title="Articles" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Статьи</h2>
                <Link :href="route('articles.add')" class="text-sm text-gray-600">Добавить статью</Link>
            </div>      
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-3">
                <div v-for="article in articles" :key="article.id">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex justify-between items-start">
                            <details class="p-6 text-gray-900 w-full">
                                <summary class="font-semibold text-lg">{{ article.title }}</summary>
                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ article.text }}
                                    <Link :href="route('articles.get', article)" class="text-sm underline"> Подробнее...</Link>    
                                </p>
                                <div class="mt-4">
                                    <Link :href="route('articles.edit', article)" class="text-sm">Изменить</Link>
                                </div>
                            </details>
                            <p class="text-sm p-6 text-gray-900 w-56">{{ article.created_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
