<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<script>
export default {
    data() {
        return {
            courseName: '',
            courseIntroduction: '',
        }
    },
    methods: {
        addCourse () {
            this.$inertia.post('/course-add', {
                course_name: this.courseName,
                course_introduction: this.courseIntroduction,
            }, {
                onSuccess: (res) => {
                    const msg = res.props.flash.message;
                    alert(msg);
                }
            });
        }
    }
}
</script>

<template>

    <Head title="TeacherList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">新增課程</h2>
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
                            <div class="flex justify-center items-center w-[200px] h-[150px] bg-gray-100 text-gray-300 cursor-pointer">點擊上傳照片</div></label><br>
                        <!-- 要用@change -->
                            <input type="file" id="course-img" class="hidden">
                    </div>
                    <div class="flex justify-center gap-2">
                        <Link href="/courselist">
                            <button type="button" class="p-3 rounded-lg text-white bg-pink-600">返回列表</button>
                        </Link>
                        <button type="button" class="p-3 rounded-lg text-white bg-blue-500" @click="addCourse">儲存</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
