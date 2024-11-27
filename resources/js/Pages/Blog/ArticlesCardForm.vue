<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    article: Object
});

const form = useForm({
    comment: ''
});

const addCommentSubmit = () => {
    axios.post(route('comment.store', props.article), {
        comment: form.comment   
    }).then(response => {
        props.article.comments.push(response.data);
        form.comment = '';
    })
};

const connectEvent = () => {
    window.Echo.channel('blog-comments')
        .listen('.comment.created', response => {
            console.log(response);
            props.article.comments.push(response.comment);
        });
}

onMounted(() => {
    connectEvent()
});


</script>

<template>
    <Head title="Article card" />

    <AuthenticatedLayout>
        <template #header>
            <Link :href="route('articles.index')" class="text-sm text-gray-600">Назад</Link>    
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-3xl text-gray-800 leading-tight">{{ props.article.title }}</p>
                        <p class=" text-gray-500 dark:text-gray-400 text-sm leading-relaxed w-56 text-right">{{ props.article.created_at }}</p>
                    </div>          
                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg leading-relaxed">{{ props.article.text }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 flex flex-col gap-4">
                    <p class="font-semibold text-lg text-gray-800 leading-tight">Комментарии</p>  
                    <form @submit.prevent="addCommentSubmit">
                        <TextAreaInput
                            id="comment"
                            type="text"
                            placeholder="Текст комментария"
                            class="mt-1 block w-full"
                            v-model="form.comment"
                            required
                            autocomplete="comment"
                        />
                        <PrimaryButton class="mt-4">
                            Добавить
                        </PrimaryButton>
                    </form>  
                    <div class="bg-gray-300 p-5 rounded-lg flex flex-col gap-3">
                        <div class="bg-white rounded-lg p-2"  v-for="comment in props.article.comments.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))" :key="comment.id">
                            <p class="font-semibold text-lg text-gray-800 leading-tight">{{ comment.user.name }}</p>  
                            <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{comment.text}}</p>
                            <div class="flex justify-end">
                                <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{ `${new Date(comment.created_at).toLocaleDateString()} ${new Date(comment.created_at).toLocaleTimeString()}` }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
