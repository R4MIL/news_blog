<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    articles: Array
});

const articleList = ref([]);

const connectEvent = () => {
    window.Echo.channel('blog-views')
        .listen('.article.getted', response => {
            const objectIndex = articleList.value.findIndex(item => item.id === response.views.article_id);
            articleList.value[objectIndex].views = response.views.views_quantity
        });

    window.Echo.channel('blog-comments-qty')
        .listen('.comment.stored', response => {
            const objectIndex = articleList.value.findIndex(item => item.id === response.commentsQty.article_id);
            articleList.value[objectIndex].commentsQty = response.commentsQty.quantity
        });     
}

onMounted(() => {
    articleList.value = props.articles ? props.articles.map(item => ({
        id: item.id,
        title: item.title,
        created_at: item.created_at,
        views: item.views.length,
        commentsQty: item.comments.length
    })) : []
    connectEvent()
});

</script>

<template>
    <Head title="Administration" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Администрирование</h2>
                <Link :href="route('articles.add')" class="text-sm text-gray-600">Добавить статью</Link>
            </div>      
        </template>
    

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <table class="border-collapse border w-full">
                        <thead>
                            <tr class="border flex">
                                <th class="border flex-1">Статьи</th>
                                <th class="border flex-none w-64">Создано</th>
                                <th class="border flex-none w-36">Кол-во просмотров</th>
                                <th class="border flex-none w-36">Кол-во комментариев</th>
                                <th class="border flex-none w-28">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="article in articleList" :key="article.id">
                                <tr class="border flex">
                                    <td class="border flex-1">{{ article.title }}</td>
                                    <td class="border flex-none w-64 text-center"> {{ article.created_at }}</td>
                                    <td class="border flex-none w-36 text-center">{{ article.views }}</td>
                                    <td class="border flex-none w-36 text-center">{{ article.commentsQty }}</td>
                                    <td class="border flex-none w-28 text-center">
                                        <Link :href="route('articles.edit', article)" class="text-sm">Изменить</Link>
                                    </td>
                                </tr>    
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
