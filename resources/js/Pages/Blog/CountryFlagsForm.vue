<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    countries: Array
});

const country = ref({});
const errorsData = ref(null);
const flagData = ref(null);

const getSubmit = () => {
    errorsData.value = null
    flagData.value = null
    axios.get(route('country.flag.get'), { params: { country: country.value }}).then(response => {
        flagData.value = response.data
    }).catch(errors => {
        errorsData.value = errors.response.data.errors
    })
};

</script>


<template>
    <Head title="Country flags" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Флаги стран</h2>
                <Link :href="route('articles.index')" class="text-sm text-gray-600">Назад</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <form @submit.prevent="getSubmit">
                        <div class="flex gap-2 items-start">
                            <div class="flex gap-1">
                                <label for="cities">Выберите страну:</label>
                                <div>
                                    <select id="cities" v-model="country">
                                        <template v-for="country in countries" :key="country.sISOCode">
                                            <option :value="country">{{ country.sName }}</option>
                                        </template>
                                    </select>
                                    <InputError class="mt-2" :message="errorsData ? errorsData.country: null" />
                                </div>      
                            </div> 
                            <PrimaryButton @click="getSubmit">
                                Получить флаг
                            </PrimaryButton>
                        </div>
                        <div class="mt-14" v-if="flagData !== null">
                            <p class="font-semibold text-lg text-gray-800 leading-tight mb-2">{{ `${country.sName} (${country.sISOCode})` }}</p>
                            <img :src="flagData" alt="img">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>