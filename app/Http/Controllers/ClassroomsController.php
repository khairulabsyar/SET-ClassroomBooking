<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreclassroomsRequest;
use App\Http\Requests\UpdateclassroomsRequest;
use App\Http\Resources\ClassroomsResource;
use App\Models\Classrooms;
use Illuminate\Support\Facades\Auth;

class ClassroomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myClass = Auth::user()->classrooms; // based on teacher model, 

        return ClassroomsResource::collection($myClass);
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
     * @param  \App\Http\Requests\StoreclassroomsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreclassroomsRequest $request)
    {
        // $class = Classrooms::create($request->all());

        $class = Auth::user()->classrooms()->create($request->all());

        return new ClassroomsResource($class);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function show(Classrooms $classroom)
    {
        // return $classroom;
        if ($classroom->teachers_id == Auth::id()) {

            return new ClassroomsResource($classroom);
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function edit(Classrooms $classrooms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateclassroomsRequest  $request
     * @param  \App\Models\Classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateclassroomsRequest $request, Classrooms $classroom)
    {
        if ($classroom->teachers_id == Auth::id()) {

            $classroom->update($request->all());

            return new ClassroomsResource($classroom);
        }

        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classrooms $classroom)
    {
        if ($classroom->teachers_id == Auth::id()) {

            $classroom->delete();

            return response()->json(null, 204);
        }

        abort(403);
    }
}