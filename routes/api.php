<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherFactoryController;
use App\Http\Controllers\TeacherResourceController;
use App\Http\Resources\ClassroomsResource;
use App\Http\Resources\TeacherResource;
use App\Jobs\CreateTeacherJob;
use App\Models\Classroom;
use App\Models\ClassroomType;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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

// Route::post('classroom-type', function () {
//     // return $request->all();

//     // ClassroomType::create($request->all());

//     // to use $attributes from ClassroomType.php
//     // make sure the post is empty
//     ClassroomType::create();

//     return ClassroomType::all();
// });

// Route::get('teacher-list', function () {
//     $data = Teacher::all();
//     return response()->json($data);
// });
// Route::get('teacher-list', [TeacherController::class, 'index']);
// // or old systax with configured RouteServiceProvider.php
// Route::get('teacher-list', 'App\Http\Controllers\TeacherController@index');

// Route::post('teacher-list', function (Request $request) {
//     //either do it here or in Teacher.php Mutator function
//     // $request['password'] = Hash::make($request->secret);
//     Teacher::create($request->all());
//     $data = Teacher::get();
//     return  response()->json($data);
// });
// Route::post('teacher-list', [TeacherController::class, 'store']);

// Route::get('teacher/{id}', function ($id) {
//     return Teacher::findOrFail($id);
// });
// Route::get('teacher/{id}', [TeacherController::class, 'show']);

// Route::put('teacher/{id}', function ($id, Request $request) {
//     // select the specific teacher based on id
//     $teacher = Teacher::findOrFail($id);
//     // update the info given in payload to that teacher
//     $teacher->update($request->all());
//     // return updated information
//     return $teacher;
//     // // basically after sending to DB it will return back to here, extra query
//     // return $teacher->refresh();
//     // // shorter version for refresh
//     // return tap($teacher)->update($request->all());
// });
// Route::put('teacher/{id}', [TeacherController::class, 'update']);

// Route::delete('teacher/{id}', function ($id) {
//     Teacher::findOrFail($id)->delete();
//     return  response()->json("Delete Teacher: " . $id, 204);
// });
// Route::delete('teacher/{id}', [TeacherController::class, 'delete']);

// // can be summarise into this line of code and make sure the name is generalise
// Route::apiResource('teacher', TeacherResourceController::class); // remove this for 13/9
// Route::get('teacher-list', [TeacherController::class, 'index']);
// Route::post('teacher-list', [TeacherController::class, 'store']);
// Route::get('teacher/{id}', [TeacherController::class, 'show']);
// Route::put('teacher/{id}', [TeacherController::class, 'update']);
// Route::delete('teacher/{id}', [TeacherController::class, 'delete']);

// // exclude some function (blacklist)
// Route::apiResource('teacher', TeacherResourceController::class)->except(['destroy']);

// // execute specific function (whitelist)
// Route::apiResource('teacher', TeacherResourceController::class)->only(['destroy']);

// // for php artisan route:list
// Route::apiResource('teacher', TeacherResourceController::class)->names('helloWorld');

// Route::get('factory-teacher', function () {
//     // generate only
//     // $generated = Teacher::factory()->make();
//     // generate and save to DB
//     $generated = Teacher::factory()->upTheName()->create();
//     return $generated;
// });
// Route::get('factory-teacher', [TeacherFactoryController::class]);

// 13/9
// Creating auth:sanctum
Route::apiResource('teacher', TeacherResourceController::class)->middleware('auth:sanctum');

/**
 * Auth login
 */
Route::post('teacher-login', [AuthController::class, 'login']);

Route::post('teacher-logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::get('auth', function () {
// dd(Auth::user(), Auth::user()->name, Auth::id());
//     return response()->json(['Test' => 'Success']);
// })->middleware('auth:sanctum');

// After authorization
Route::get('auth', function () {
    // dd(Auth::user(), Auth::user()->name, Auth::id());
    return response()->json(['Test' => 'Success']);
    // dd("hello");
})->middleware('auth:sanctum', 'role:Administrator|Support`');

// giving permission
Route::get('permission-to-role', function () {
    // seed permission 'teacher:edit', 'teacher;delete'
    // php artisan permission:create-permission "teacher:delete"
    // php artisan permission:create-permission "teacher:edit"

    // extract the role
    $role = Role::findbyName('Administrator');

    // give permission to role
    $role->givePermissionTo(['teacher:edit', 'teacher:delete']);

    return $role;
});

Route::get('permission-test', function () {
    return 'Success';
})->middleware(['permission:teacher:edit|teacher:delete']);

// 14/9
/*
 *  Test middelware to check inside request has 'isAdmin' key
 */
Route::post('middleware-test', function (Request $request) {
    return 'User no: ' . $request->has('isAdmin');
})->middleware('is_admin'); // ->middleware(isAdminExistMiddleware::class)

//exclude
// Route::group(function () {
//     // specific route to exclude
//     Route::get('/')->withoutMiddleware(['is_admin']);

//     Route::post('/');
//     // all other route will use 'is_admind' middleware
// })->middleware('is_admin');

Route::get('all-teachers', function () {
    $teachers = Teacher::all();
    // dd($teachers); // give collection
    return response()->json(TeacherResource::collection($teachers));
});

// Route::get('one-teacher', function () {
//     $teacher = Teacher::first();
//     // dd($teacher); give teacher model
//     return response()->json(new TeacherResource($teacher));
// });

Route::get('one-teacher', function () {
    $teacher = Teacher::first();
    $teacher['pass_data'] = "This pass data";
    return response()->json(new TeacherResource($teacher));
});

Route::apiResource('classroom', ClassroomsController::class)->middleware('auth:sanctum');

Route::post('classroom/search', function (Request $request) {
    $request->validate([
        'teachers_id' => 'exists:teachers,id',
        'type_name' => 'string',
        'search_topic' => 'string|min:3',
        'search_teacher_name' => 'string',
    ]);

    // $collection = Classroom::query()
    //     ->when($request->teacher_id, function ($q) use ($request) {
    //         $q->where('teachers_id', $request->teacher_id);
    //     })
    //     ->when($request->type_name, function ($q) use ($request) {
    //         // usiang relation to query
    //         $q->whereHas('classroomType', function ($x) use ($request) {
    //             $x->where('name', $request->type_name);
    //         });
    //     })
    //     ->when($request->search_topic, function ($q) use ($request) {
    //         $q->where('name', 'like', "%$request->search_topic%");
    //     })
    //     ->when($request->search_teacher_name, function ($q) use ($request) {
    //         $q->where('teacher', function ($x) use ($request) {
    //             $x->where('name', 'like', "%$request->search_teacher_name%");
    //         });
    //     })
    //     ->get();

    $collection = Classroom::query()
        ->when($request->teachers_id, function ($que) use ($request) {
            $que->where('teachers_id', $request->teachers_id);
        })
        ->when($request->type_name, function ($que) use ($request) {
            $que->whereHas('classroomType', function ($que) use ($request) {
                $que->where('type', $request->type_name);
            });
        })
        ->when($request->search_topic, function ($que) use ($request) {
            $que->where('name', 'like', "%$request->search_topic%");
        })
        ->when($request->search_teacher_name, function ($que) use ($request) {
            $que->whereHas('teacher', function ($que) use ($request) {
                $que->where('name', 'like', "%$request->search_teacher_name%");
            });
        })->get();

    return ClassroomsResource::collection($collection);
});

// 19/9
Route::get('execute-job', function () {
    CreateTeacherJob::dispatch("Ironman");

    // can add delay, seems like tak function
    // CreateTeacherJob::dispatch("Ironman")->delay(now()->addMinutes(0.5));

    return "Success";
});

// 20/9
Route::get('mailtrap-inboxes', function () {
    $account_id =  config('services.mailtrap.account_id');

    $baseUrl = "https://mailtrap.io/api";
    $url = "/accounts/" . $account_id . '/inboxes';

    $response = Http::acceptJson()
        ->withHeaders([
            "Api-Token" => config('services.mailtrap.token')
        ])->get($baseUrl . $url);

    if ($response->successful()) {

        // return $response->body();

        // // $result = json_decode($response, true);
        // // return $result[0]['project_id'];

        $collection = $response->collect();
        return $collection->pluck('project_id');
    }

    return response()->json('Something Wrong', 400);
});
