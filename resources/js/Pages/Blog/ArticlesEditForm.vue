<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    article: Object
});

const form = useForm({
    title: props.article.title,
    text: props.article.text
});

const updateSubmit = () => {
    form.post(route('articles.update', props.article.id));
};

const deleteSubmit = () => {
    form.post(route('articles.delete', props.article.id));
};

</script>

<template>
    <Head title="Article update" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Изменение статьи</h2>
                <Link :href="route('administration.index')" class="text-sm text-gray-600">Назад</Link>
            </div>      
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <form @submit.prevent="updateSubmit">
                        <div>
                            <InputLabel for="title" value="Название статьи" />
                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                required
                                autofocus
                                autocomplete="title"
                            />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="text" value="Текст статьи" />
                            <TextAreaInput
                                id="text"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.text"
                                required
                                autocomplete="text"
                            />
                            <InputError class="mt-2" :message="form.errors.text" />
                        </div>
                        <div class="mt-4 flex gap-4">
                            <PrimaryButton  :class="{ 'opacity-25': form.processing }">
                                Изменить
                            </PrimaryButton>
                            
                            <form @submit.prevent="deleteSubmit">
                                <PrimaryButton  :class="{ 'opacity-25': form.processing }">
                                    Удалить
                                </PrimaryButton>
                            </form>                       
                        </div>         
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
