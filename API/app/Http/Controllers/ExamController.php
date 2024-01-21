<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $exams = Exam::paginate(6);

        return response()->json($exams);
        //return view('students.index')->with('students',$students);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('exams.create');
    }
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'title'=>"required|max:21",
            'venue'=>"required|max:21",
            'date'=>'required',
            'time'=>'required',
            'duration'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'error' => $validator->messages(),
            ], 422);
        }

        $exams = new Exam();
        $exams->id = \Ramsey\Uuid\Uuid::uuid4();

        $exams->title = $request->title;
        $exams->venue = $request->venue;
        $exams->date = $request->date;
        $exams->time = $request->time;
        $exams->duration = $request->duration;
        $exams->save();

        return response()->json(['message' => 'Exam created successfully',
        'exam' => $exams], Response::HTTP_CREATED);
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $exam = Exam::find($id);


        if($exam){
            return response()->json($exam);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Record not found',
            ], 404);
        }

       // return view('students.show')->with('students', $student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // $student = Student::find($id);
        // return view('students.edit')->with('students', $student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(),[
            'title'=>"required|max:21",
            'venue'=>"required|max:21",
            'date'=>'required|date',
            'time'=>'required',
            'duration'=>'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 422,
                    'error' => $validator->messages(),
                ], 422);
            }

        $exam = Exam::find($id);

        if (!$exam) {
            return response()->json(['message' => 'Event not found'], Response::HTTP_NOT_FOUND);
        }

         $exam->fill($request->only(['title','venue','date','time','duration']));
         $exam->save();

        return response()->json(['message' => 'Exam info updated successfully',
        'exams' => $exam], Response::HTTP_OK);

    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $exam = Exam::find($id);

        if ($exam) {
            $exam->delete();
            return response()->json(['message' => 'Exam deleted successfully'], Response::HTTP_OK);

        } else {
            return response()->json(['message' => 'Exam not found'], Response::HTTP_NOT_FOUND);
        }
    }


    // public function enrollStudents(Request $request, $examId)
    // {
    //     $request->validate([
    //         'student_ids' => 'required|array',
    //         'student_ids.*' => 'exists:students,id',
    //     ]);

    //     $exam = Exam::findOrFail($examId);
    //     $students = Student::find($request->student_ids);

    //     $exam->students()->sync($students);

    //     return response()->json(['message' => 'Students enrolled successfully']);
    // }

    // public function listEnrolledStudents($examId)
    // {
    //     $exam = Exam::findOrFail($examId);
    //     $enrolledStudents = $exam->students;

    //     return response()->json(['enrolled_students' => $enrolledStudents]);
    // }
}
