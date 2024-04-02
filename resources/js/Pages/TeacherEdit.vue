<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<script>
export default {
    data() {
        return {
            teacherName: '',
            teacherIntroduction: '',
            courseId: 0,
        }
    },
    props: {
        response: {
            type: Object,
        },
        id: {
            type: String,
        },
        course: {
            type: Object,
        },
    },
    mounted() {
        this.teacherName = this.response.find(item => item.id === this.id).teacher_name;
        this.teacherIntroduction = this.response.find(item => item.id === this.id).teacher_introduction;
        this.courseId = this.response.find(item => item.id === this.id).course_id;
    },
    methods: {
        editSave () {
            this.$inertia.post('teacher-save', {
                teacher_name: this.teacherName,
                teacher_introduction: this.teacherIntroduction,
                id: this.id,
                course_id: this.courseId,
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">編輯教師</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 p-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div>
                        <label for="class-set">課程</label><br>
                        <select name="" id="class-set" v-model="courseId">
                            <option value="請選擇課程" disabled selected>請選擇課程</option>
                            <option v-for="item in course" :key="item.id" :value="item.id">{{ item.course_name }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="class-teacher">教師姓名</label><br>
                        <input v-model="teacherName" type="text" id="class-teacher" class="w-full">
                    </div>
                    <div class="mb-5">
                        <label for="teacher-introduction">教師簡介</label><br>
                        <input v-model="teacherIntroduction" type="text" id="teacher-introduction" class="w-full">
                    </div>
                    <div class="flex justify-center gap-2">
                        <Link href="/teacherlist">
                            <button type="button" class="p-3 rounded-lg text-white bg-pink-600">返回列表</button>
                        </Link>
                        <button type="button" class="p-3 rounded-lg text-white bg-blue-500" @click="editSave">儲存</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
