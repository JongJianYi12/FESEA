<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Faker\Factory as Faker;

use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $students = Student::paginate(6);

        return response()->json($students);
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
        return view('students.create');



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name'=>"max:51|required",
            'gender'=>"max:1|required",
            'email'=>'required|email|max:100',
            'yearOfStudy'=>'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'error' => $validator->messages(),
            ], 422);
        }

        $students = new Student();

        $students->name = $request->name;
        $students->gender = $request->gender;
        $students->email = $request->email;
        $students->examno = $this->faker->unique()->regexify('[A-Z]{3}[1-9]{6}[A-Z]{3}');
        $students->yearOfStudy = $request->yearOfStudy;
        $students->save();

        return response()->json(['message' => 'Student created successfully',
        'events' => $students], Response::HTTP_CREATED);
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
        $student = Student::find($id);


        if($student){
            return response()->json($student);
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
            'name'=>"max:51|required",
            'gender'=>"max:1|required",
            'email'=>'required|email|max:100',
            'yearOfStudy'=>'required|numeric',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 422,
                    'error' => $validator->messages(),
                ], 422);
            }

        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Event not found'], Response::HTTP_NOT_FOUND);
        }

         $student->fill($request->only(['name','gender','email','yearOfStudy']));
         $student->save();

        return response()->json(['message' => 'Student info updated successfully',
        'students' => $student], Response::HTTP_OK);

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

        $student = Student::find($id);

        if ($student) {
            $student->delete();
            return response()->json(['message' => 'Student deleted successfully'], Response::HTTP_OK);

        } else {
            return response()->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }
    }


    public function updateStatusByFingerprintId($fingerprintId)
    {
        // Search for the record with the specified search field value
        $record = Student::where('fingerId', $fingerprintId)->first();
        // Check if a record is found
        if ($record) {
            // Update the status field

            $record->status = 'TRUE';

            $result = $record->save();

            // $record->fill(['status' => 'TRUE']); // update attendance status
            return response()->json(['message' => 'Status updated successfully','attendance' => $record, Response::HTTP_OK]);
        } else {
            return response()->json(['message' => 'Record not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function updateStatusByStudentId($studentId)
    {
        // Search for the record with the specified search field value
        $record = Student::where('id', $studentId)->first();
        // Check if a record is found
        if ($record) {
            // Update the status field

            $record->status = 'TRUE';

            $result = $record->save();

            // $record->fill(['status' => 'TRUE']); // update attendance status
            return response()->json(['message' => 'Status updated successfully','attendance' => $record, Response::HTTP_OK]);
        } else {
            return response()->json(['message' => 'Record not found'], Response::HTTP_NOT_FOUND);
        }
    }

    //send id to arduino
    public function sendSidForFingerPrintRegistration(Request $request)
    {
        $data = $request->all();
        $response = Http::post('http://arduino-api-endpoint', $data);
        return response()->json(['success' => true, 'data' => $data]);
    }

    //arduino call after save sid and fingerprint
    public function fingerPrintRegistration($studentId)
    {

        $record = Student::where('id', $studentId)->first();
        if ($record) {
            //arduino save studentId
            //wait(1000)
            //update fingerprint status

            $record->fingerStatus = 'TRUE';
            $result = $record->save();
            return response()->json(['message' => 'Student fingerprint registered successfully','student' => $record, Response::HTTP_OK]);



        } else {
            return response()->json(['message' => 'Record not found'], Response::HTTP_NOT_FOUND);
        }




    }


}
