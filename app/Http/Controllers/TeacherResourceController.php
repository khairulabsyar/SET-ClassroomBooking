<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests\AddTeacherRequest;
use App\Http\Resources\TeacherResource;
use Illuminate\Routing\Controller;

class TeacherResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Teacher::all();

        return response()->json(TeacherResource::collection($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTeacherRequest $request)
    {
        // Teacher::create($request->all());
        // $data = Teacher::get();
        // return  response()->json($data);

        // after authorization

        $teacher = Teacher::create($request->all());

        // assign role to Admin
        // $teacher->assignRole('Administrator');
        $teacher->assignRole('Support');
        $teacher->assignRole('Developer');

        return response()->json($teacher);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Teacher::findOrFail($id);
        // for authorization
        // give authorization to teacher based on id in database
        $teacher = Teacher::findOrFail($id);

        $this->authorize('view', $teacher);

        return $teacher;
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
        $data = $request->validate([
            'name' => 'string|required'
        ], [
            'name.required' => 'Name diperlukan'
        ]);

        $teacher = Teacher::findOrFail($id);

        // update for authorization
        $this->authorize('view', $teacher);

        // $teacher->update($request->all());

        // return $teacher;
        // or
        // return tap($teacher)->update($request->all());
        return tap($teacher)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();

        return  response()->json("Delete Teacher: " . $id, 204);
    }
}
