<?php

use App\Models\ClassroomType;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('classroom-type', function () {
    // return $request->all();

    // ClassroomType::create($request->all());

    // to use $attributes from ClassroomType.php
    // make sure the post is empty
    ClassroomType::create();

    return ClassroomType::all();
});

/**
 * Return list of teachers
 */
Route::get('teacher-list', function () {
    $data = Teacher::all();
    return response()->json($data);
});

/**
 * Add  new teacher
 * store()
 */
Route::post('teacher-list', function (Request $request) {

    //either do it here or in Teacher.php Mutator function
    // $request['password'] = Hash::make($request->secret);

    Teacher::create($request->all());
    $data = Teacher::get();
    return  response()->json($data);
});

/**
 * Get the specific teacher
 * show()
 */
Route::get('teacher/{id}', function ($id) {
    return Teacher::findOrFail($id);
});

/**
 * Update existing teacher by his/her id
 * update()
 */
Route::put('teacher/{id}', function ($id, Request $request) {
    // select the specific teacher based on id
    $teacher = Teacher::findOrFail($id);

    // update the info given in payload to that teacher
    $teacher->update($request->all());

    // return updated information
    return $teacher;

    // // basically after sending to DB it will return back to here, extra query
    // return $teacher->refresh();

    // // shorter version for refresh
    // return tap($teacher)->update($request->all());
});

/**
 * Delete an existing teacher
 * destroy()
 */
Route::delete('teacher/{id}', function ($id) {
    Teacher::findOrFail($id)->delete();

    return  response()->json("Delete Teacher: " . $id, 204);
});


// Factory, create a fake data
Route::get('factory-teacher', function () {
    // generate only
    // $generated = Teacher::factory()->make();

    // generate and save to DB
    $generated = Teacher::factory()->upTheName()->create();

    return $generated;
});