<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests\AddTeacherRequest;

class TeacherController extends Controller
{
    /**
     * Return list of teachers
     * index()
     */
    public function index()
    {

        $data = Teacher::all();

        return response()->json($data);
    }

    /**
     * Add  new teacher
     * store()
     */
    public function store(AddTeacherRequest $request)
    {
        Teacher::create($request->all());

        $data = Teacher::get();

        return  response()->json($data);
    }

    /**
     * Get the specific teacher
     * show()
     */
    public function show($id)
    {
        // return Teacher::findOrFail($id);

        //for authorization
        // give authorization to teacher based on id in database
        $teacher = Teacher::findOrFail($id);

        $this->authorize('view', $teacher);

        return $teacher;
    }

    /**
     * Update existing teacher by his/her id
     * update()
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        // $teacher->update($request->all());

        // return $teacher;
        // or
        return tap($teacher)->update($request->all());
    }

    /**
     * Delete an existing teacher
     * destroy()
     */
    public function delete($id)
    {
        Teacher::findOrFail($id)->delete();

        return  response()->json("Delete Teacher: " . $id, 204);
    }
}