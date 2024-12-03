<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    cities: Array
});

const city = ref('')
const errorsData = ref(null);
const weatherData = ref(null);

const getSubmit = () => {
    errorsData.value = null
    weatherData.value = null
    axios.get(route('weather.get'), { params: { city: city.value }}).then(response => {
        weatherData.value = response.data
    }).catch(errors => {
        errorsData.value = errors.response.data.errors
    })
};

</script>


<template>
    <Head title="Weather" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Погода</h2>
                <Link :href="route('articles.index')" class="text-sm text-gray-600">Назад</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <form @submit.prevent="getSubmit">
                        <div class="flex gap-2 items-start">
                            <div class="flex gap-1">
                                <label for="cities">Выберите город:</label>
                                <div>
                                    <select id="cities" v-model="city">
                                        <template v-for="city in cities" :key="city">
                                            <option :value="city">{{ city }}</option>
                                        </template>
                                    </select>
                                    <InputError class="mt-2" :message="errorsData ? errorsData.city: null" />
                                </div>      
                            </div> 
                            <PrimaryButton @click="getSubmit">
                                Получить
                            </PrimaryButton>
                        </div>
                        <div class="mt-14" v-if="weatherData !== null">
                            <p class="font-semibold text-lg text-gray-800 leading-tight">{{ weatherData.city }}</p>
                            <div class="mt-3 flex gap-4">
                                <div>
                                    <img :src="weatherData.img" alt="img">
                                    <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{ weatherData.weather }}</p>
                                </div>
                                <div class>
                                    <p class="text-3xl">{{ `${weatherData.temp} °C` }}</p>
                                    <p class="">{{ `Ощущается как ${weatherData.feels_like} °C` }}</p>
                                </div>
                                <div class="flex flex-col gap-y-1">
                                    <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Давление: {{ weatherData.pressure }} гПа</p>
                                    <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Влажность: {{ weatherData.humidity }} %</p>
                                    <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Скорость ветра: {{ weatherData.wind }} км/ч</p>
                                  
                                </div>
                            </div>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>