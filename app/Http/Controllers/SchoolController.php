<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Curriculum;

use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class SchoolController extends Controller
{
    //
    public function courseAdd(Request $request)
    {
        $message = '';
        try {
            Course::create([
                'course_name' => $request->course_name,
                'course_introduction' => $request->course_introduction,
            ]);
            $message = '新增成功';
        } catch (\Throwable $th) {
            $message = '新增失敗';
        }
        return redirect('/courselist')->with(['message' => $message]);
    }

    public function viewCourselist()
    {
        $courselist = Course::get();
        return Inertia::render('CourseList', [
            'response' => $courselist,
        ]);
    }

    public function viewTeacherlist()
    {
        $teacherlist = Teacher::get();
        return Inertia::render('TeacherList', [
            'response' => $teacherlist,
        ]);
    }

    public function editCourse(Request $request)
    {
        $courselist = Course::get();
        return Inertia::render('CourseEdit', [
            'response' => $courselist,
            'id' => $request['id'],
        ]);
    }

    public function courseSave(Request $request)
    {
        $message = '';
        try {
            $course = Course::find($request->id);

            $course->update([
                'course_name' => $request->course_name,
                'course_introduction' => $request->course_introduction,
            ]);
            $message = '編輯成功';
        } catch (\Throwable $th) {
            $message = '編輯失敗';
        }
        return redirect('/courselist')->with(['message' => $message]);
    }

    public function deleteCourse(Request $request)
    {
        $course = Course::find($request->id);
        $message = '';
        if ($course) {
            $course->delete();
            $message = '刪除成功';
        } else {
            $message = '刪除失敗';
        }
        return redirect('/courselist')->with(['message' => $message]);
    }

    public function teacherAdd(Request $request)
    {
        $message = '';
        try {
            Teacher::create([
                'teacher_name' => $request->teacher_name,
                'teacher_introduction' => $request->teacher_introduction,
                'course_id' => $request->course_id,
            ]);
            $message = '新增成功';
        } catch (\Throwable $th) {
            $message = '新增失敗';
        }
        return redirect('/teacherlist')->with(['message' => $message]);
    }

    public function editTeacher(Request $request)
    {
        $teacherlist = Teacher::get();
        $courselist = Course::get();
        return Inertia::render('TeacherEdit', [
            'response' => $teacherlist,
            'course' => $courselist,
            'id' => $request['id'],
        ]);
    }

    public function teacherSave(Request $request)
    {
        $message = '';
        try {
            $teacher = Teacher::find($request->id);

            $teacher->update([
                'teacher_name' => $request->teacher_name,
                'teacher_introduction' => $request->teacher_introduction,
                'course_id' => $request->course_id,
            ]);
            $message = '編輯成功';
        } catch (\Throwable $th) {
            $message = '編輯失敗';
        }
        return redirect('/teacherlist')->with(['message' => $message]);
    }

    public function deleteTeacher(Request $request)
    {
        $teacher = Teacher::find($request->id);
        $message = '';
        if ($teacher) {
            $teacher->delete();
            $message = '刪除成功';
        } else {
            $message = '刪除失敗';
        }
        return redirect('/teacherlist')->with(['message' => $message]);
    }

    public function curriculumAdd()
    {
        $courseTeacher = Teacher::with('course')->get();
        return Inertia::render('CurriculumAdd', [
            'response' => $courseTeacher,
        ]);
    }

    public function curriculumSave(Request $request)
    {
        foreach ($request->selectlist as $item) {
            $findTeacher = Teacher::find($item['id']);
            $findTeacher->select = $item['select'];
            $findTeacher->save();
        }
        $message = '';
        try {
            Term::create([
                'school_year' => $request->school_year,
                'term' => $request->term,
            ]);
            foreach ($request->curriculumlist as $item) {
                $teacherId = $item['id'];
                $courseId = $item['course']['id'];


                $termlist = Term::latest()->first();

                Curriculum::create([
                    'teacher_id' => $teacherId,
                    'course_id' => $courseId,
                    'term_id' => $termlist->id,
                ]);
                $message = '新增成功';
            }
        } catch (\Throwable $th) {
            $message = '新增失敗';
        }
        if (!$message) {
            $message = '請新增課程';
            return back()->with(['message' => $message]);
        }
        return redirect('/curriculumlist')->with(['message' => $message]);
    }

    public function editCurriculum(Request $request)
    {
        $term = Term::find($request->term_id);
        $teacher = Teacher::with('course')->get();
        $curriculumlist = Curriculum::where('term_id', $request->term_id)->get();
        $data = [];
        foreach ($curriculumlist as $curriculum) {
            $teacherId = $curriculum->teacher_id;
            $data[] = $teacherId;
        }
        return Inertia::render('CurriculumEdit', [
            'response' => $teacher,
            'term' => $term,
            'teacherId' => $data,
        ]);
    }

    public function curriculumUpdate(Request $request)
    {
        foreach ($request->selectlist as $item) {
            $findTeacher = Teacher::find($item['id']);
            if ($findTeacher) {
                $findTeacher->select = $item['select'];
                $findTeacher->save();

                if ($item['select'] == 0) {
                    Curriculum::where('teacher_id', $item['id'])->delete();
                }
            }
        }
        $termId = $request->term['id'];
        $message = '';
        try {
            foreach ($request->curriculumlist as $item) {
                $teacherId = $item['id'];
                $courseId = $item['course']['id'];

                 $existingCurriculum = Curriculum::where('teacher_id', $teacherId)
                                              ->where('course_id', $courseId)
                                              ->where('term_id', $termId)
                                              ->exists();
            if (!$existingCurriculum) {
                Curriculum::create([
                    'teacher_id' => $teacherId,
                    'course_id' => $courseId,
                    'term_id' => $termId,
                ]);
            }
        }
        $message = '更新成功';
        } catch (\Throwable $th) {
            $message = '更新失敗';
        }
        if (!$message) {
            $message = '請新增課程';
            return back()->with(['message' => $message]);
        }
        return redirect('/curriculumlist')->with(['message' => $message]);
    }
}
