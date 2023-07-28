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
    code?: number,
    reg?: string,
    exp?: string,
    exp_date?: string
};

const form = useForm({
    phone: '',
});
let phones: string = '';
const phone_code: Array<Package> = reactive([]);

const submit = () => {
    phone_code.length = 0;

    let list_phone: Array<string> = phones.split("\n");
    list_phone.forEach((val: string) => {
        if (val.length) {
            form.phone = val;
            axios.post(route('c2c.crawl'), {
                phone: val
            }).then(function({data}: any) {
                if (data.success) {
                    if (typeof data.data[0] == 'object') {
                        phone_code.push({
                            'phone': val,
                            'code': data.data[0].PCK_CODE,
                            'exp': data.data[0].EXPIRE_DATETIME,
                            'exp_date': data.data[0].EXPIRE_DATE,
                            'reg': data.data[0].REG_DATETIME,
                        });
                    }
                }
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
                            <textarea v-model="phones" id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="09xxxxxxxx" required></textarea>
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
                        <div v-for="(pack, index) in phone_code" :key="index">{{ pack.phone }} - {{ pack.code }} - {{ pack.reg }} - {{ pack.exp }}</div>
                    </div>
                </div>
                <!-- <p class="ml-auto text-xs text-gray-500 dark:text-gray-400">Remember, contributions to this topic should follow our <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">Community Guidelines</a>.</p> -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
