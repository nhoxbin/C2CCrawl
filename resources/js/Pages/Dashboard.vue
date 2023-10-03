<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { reactive } from 'vue';

defineProps<{
    success?: boolean,
    msg?: string,
    data?: any
}>();

type Package = {
    phone?: string,
    data?: {
        PCK_CODE?: string,
        REG_DATETIME?: string,
        EXPIRE_DATETIME?: string,
        EXPIRE_DATE?: string
    }
};

const form = useForm({
    phone: '',
});
let phoneText: string = '';
const phone_data: Array<Package> = reactive([]);
let list_phone: Array<string> = reactive([]);

const submit = () => {
    phone_data.length = 0;
    list_phone = phoneText.split("\n");

    list_phone.forEach((val: string) => {
        if (val.length) {
            form.phone = val;
            axios.post(route('c2c.crawl'), form).then(function({data}: any) {
                if (data.success && data.data.length) {
                    // data.data['phone'] = val;
                    phone_data.push({
                        'phone': val,
                        'data': data.data,
                    });
                    /*  */
                }/*  else {
                    phone_code.push();
                } */
            });
        }
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
                <form @submit.prevent="submit">
                    <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                            <label for="comment" class="sr-only">Danh sách số điện thoại</label>
                            <textarea v-model="phoneText" id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="09xxxxxxxx" required></textarea>
                        </div>
                        <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                            <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                Lấy dữ liệu
                            </button>
                        </div>
                    </div>
                </form>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-for="(data, index) in phone_data" :key="index">
                            <label :for="data.phone">{{ data.phone }}</label>
                            <div v-for="(row, i) in data.data" :key="i">
                                <div v-if="i == 0 || i == 3">
                                    {{ row.PCK_CODE }} ({{ row.REG_DATETIME }} - {{ row.EXPIRE_DATETIME }})
                                </div>
                                <label v-else :for="row.PCK_CODE">{{ row.PCK_CODE }}</label>
                            </div>
                            <br />
                        </div>
                    </div>
                </div>
                <!-- <p class="ml-auto text-xs text-gray-500 dark:text-gray-400">Remember, contributions to this topic should follow our <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">Community Guidelines</a>.</p> -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
