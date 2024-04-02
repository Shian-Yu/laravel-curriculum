<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import chinese from '/images/chinese.png';
</script>

<script>
export default {
    data() {
        return {
            courseName: '',
            courseIntroduction: '',
        }
    },
    props: {
        response: {
            type: Object,
        },
        id: {
            type: String,
        }
    },
    mounted() {
        this.courseName = this.response.find(item => item.id === this.id).course_name;
        this.courseIntroduction = this.response.find(item => item.id === this.id).course_introduction;
    },
    methods: {
        editSave () {
            this.$inertia.post('course-save', {
                course_name: this.courseName,
                course_introduction: this.courseIntroduction,
                id: this.id,
            },
            {
                onSuccess: (res) => {
                    const msg = res.props.flash.message;
                    alert(msg);
                }
            }
            )
        }
    }
}
</script>

<template>
    <Head title="TeacherList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">編輯課程</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 p-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div>
                        <label for="class-teacher">課程名稱</label><br>
                        <input v-model="courseName" type="text" id="class-teacher" class="w-full">
                    </div>
                    <div>
                        <label for="teacher-introduction">課程簡介</label><br>
                        <input v-model="courseIntroduction" type="text" id="teacher-introduction" class="w-full">
                    </div>
                    <div class="mb-5">
                        <label for="course-img">課程照片
                            <img :src="chinese" alt="" class="cursor-pointer"></label><br>
                        <input type="file" id="course-img" class="hidden">
                    </div>
                    <div class="flex justify-center gap-2">
                        <Link href="/courselist">
                            <button type="button" class="p-3 rounded-lg text-white bg-pink-600">返回列表</button>
                        </Link>
                        <button type="button" class="p-3 rounded-lg text-white bg-blue-500" @click="editSave">儲存</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
