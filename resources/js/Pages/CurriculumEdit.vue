<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import flag from '/images/flag.svg';

</script>

<script>
export default {
    props: {
        response: {
            type: Object,
        },
        term: {
            type: Object,
        },
        teacherId: {
            type: Object,
        },
    },
    data() {
        return {
            curriculumlist: [],
            courseName: '',
            courseIntroduction: '',
            selectlist: [],
            schoolYear: this.term.school_year,
            termYear: this.term.term,
        }
    },
    mounted() {
        this.selectlist = this.response.filter(item => item.select == false || this.teacherId.includes(item.id));
        this.noselectlist = this.response.filter(item => item.select == false);
        this.curriculumlist = this.response.filter(item => this.teacherId.includes(item.id));

        this.response.forEach(item => {
        item.select = Boolean(item.select);
    });
    },
    methods: {
        addCurriculum() {
            this.curriculumlist = this.selectlist.filter(item => item.select == true);
            this.noselectlist = this.selectlist.filter(item => item.select == false);
        },
        updateTeacherId(id, selected) {
            if (selected) {
                this.teacherId.push(id);
            } else {
                const index = this.teacherId.indexOf(id);
                if (index !== -1) {
                    this.teacherId.splice(index, 1);
                }
            }
        },
        curriculumUpdate() {
            this.$inertia.post('/curriculum-update', {
                curriculumlist: this.curriculumlist,
                school_year: this.schoolYear,
                selectlist: this.response,
                term: this.term,
            }, {
                onSuccess: (res) => {
                    const msg = res.props.flash.message;
                    alert(msg);
                }
            });
        }
    },
}
</script>

<template>

    <Head title="TeacherList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">編輯課表</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 p-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between gap-2">
                        <div class="w-1/2">
                            <label for="class-teacher">學年度</label><br>
                            <input v-model="schoolYear" type="number" id="class-teacher" class="w-full">
                        </div>
                        <div class="w-1/2">
                            <label for="teacher-introduction">學期</label><br>
                            <input v-model="termYear" type="text" id="teacher-introduction" class="w-full">
                        </div>
                    </div>
                    <div class="mb-5 flex justify-center gap-2">
                        <div class="w-2/5 min-h-[300px] rounded-lg overflow-hidden border border-black">
                            <table class="w-full text-center">
                                <thead>
                                    <tr class="grid">
                                        <th class="bg-gray-300">全部課程</th>
                                    </tr>
                                    <tr class="grid grid-cols-2 border-y border-black bg-gray-300">
                                        <th class="col-span-1">課程</th>
                                        <th class="col-span-1">教師</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <label v-for="item in noselectlist" :for="item.id" :key="item.id"
                                            class="grid grid-cols-2 border-b">
                                            <td :class="{ 'bg-blue-500': item.select }"
                                                class="flex justify-center items-center col-span-1">{{
                                item.course.course_name
                            }}
                                            </td>
                                            <td :class="{ 'bg-blue-500': item.select }"
                                                class="flex justify-center items-center col-span-1">{{ item.teacher_name
                                                }}
                                            </td>
                                            <input v-model="item.select" @change="updateTeacherId(item.id, item.select)"
                                                type="checkbox" :id="item.id" class="hidden">
                                        </label>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="w-1/5 flex justify-center items-center">
                            <img :src="flag" alt="" class="w-16" @click="addCurriculum">
                        </div>
                        <div class="w-2/5 min-h-[300px] rounded-lg overflow-hidden border border-black">
                            <table class="w-full text-center">
                                <thead>
                                    <tr class="grid">
                                        <th class="bg-gray-300">全部課程</th>
                                    </tr>
                                    <tr class="grid grid-cols-2 border-y border-black bg-gray-300">
                                        <th class="col-span-1">課程</th>
                                        <th class="col-span-1">教師</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <label v-for="item in curriculumlist"
                                            :for="item.id" :key="item.id" class="grid grid-cols-2 border-b">
                                            <td :class="{ 'bg-blue-500': !item.select }"
                                                class="flex justify-center items-center col-span-1">{{
                                item.course.course_name
                            }}
                                            </td>
                                            <td :class="{ 'bg-blue-500': !item.select }"
                                                class="flex justify-center items-center col-span-1">{{ item.teacher_name
                                                }}
                                            </td>
                                            <input v-model="item.select" @change="updateTeacherId(item.id, item.select)"
                                                type="checkbox" :id="item.id" class="hidden">
                                        </label>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex justify-center gap-2">
                        <Link href="/curriculumlist">
                        <button type="button" class="p-3 rounded-lg text-white bg-pink-600">返回列表</button>
                        </Link>
                        <button type="button" class="p-3 rounded-lg text-white bg-blue-500"
                            @click="curriculumUpdate">儲存</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
