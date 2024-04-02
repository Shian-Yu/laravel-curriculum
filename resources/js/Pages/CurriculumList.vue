<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<script>
export default {
    data() {
        return {
        }
    },
    props: {
        response: {
            type: Object,
        },
    },
    methods: {
        editCurriculum (id) {
            this.$inertia.post('/curriculumedit', {
                term_id: id,
            },
            )
        }
    }
}
</script>

<template>

    <Head title="TeacherList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">課程列表</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Link :href="route('curriculumadd')">
                    <button type="button" class="mb-4 py-1 px-3 rounded-lg text-white bg-green-500">新增</button>
                    </Link>
                    <table class="w-full border border-black text-center">
                        <thead>
                            <tr class="grid grid-cols-12">
                                <th class="col-span-1 border-black border">序號</th>
                                <th class="col-span-4 border-black border">學年</th>
                                <th class="col-span-4 border-black border">學期</th>
                                <th class="col-span-3 border-black border">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in response" :key="item.id" class="grid grid-cols-12">
                                <td class="flex justify-center items-center col-span-1 border-black border">{{ item.id }}</td>
                                <td class="flex justify-center items-center col-span-4 border-black border">{{ item.school_year }}</td>
                                <td class="flex justify-center items-center col-span-4 border-black border p-1">{{ item.term }}</td>
                                <td class="flex justify-center items-center gap-1 col-span-3 border-black border">
                                    <button type="button" class="p-2 rounded-lg text-white bg-stone-500">寄出</button>
                                    <button type="button" class="p-2 rounded-lg text-white bg-blue-500" @click="editCurriculum(item.id)">編輯</button>
                                    <button type="button" class="p-2 rounded-lg text-white bg-red-500">刪除</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
