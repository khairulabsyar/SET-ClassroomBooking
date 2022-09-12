<?php

use App\Models\ClassroomType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/student-list', function () {
Route::get('/', function () {
    // dump("Route"); // 1

    // 3. if use about will return as error page
    // abort(500);

    // 2. to return as json
    // return response()->json([
    //     "Testing Route" => "Hello Route"
    // ]);

    // 4. sending database to webserver
    // $data = DB::select('SELECT * FROM students');
    // return response()->json($data);

    return view('page.original_welcome'); // original
});

Route::view('welcome-1', 'page.modified_welcome');
// Route::get('/welcome', function () {
//     return view('page.modified_welcome');
// });

Route::view('email', 'page.email_welcome')->name('email');
// Route::get('/email', function () {
//     return view('page.email_welcome');
// });

// passing variable
Route::get('welcome-2', function () {
    $var1 = 3;
    $var2 = 4;
    return view('page.modified_welcome', ["totalSum" =>  $var1 * $var2]);
});

// new request
use Illuminate\Http\Request;

Route::get('welcome-3', function (Request $request) {

    // get input from request and convert into array
    $data = $request->all();

    $var1 = $data['var3'] ?? 0;
    $var2 = $data['a'] ?? 0;

    return view('page.modified_welcome', ["totalSum" =>  $var1 * $var2]);
})->name('welcome3');

// shorter version check app.php in config folder
// Route::get('welcome-3', function (\HttpRequest $request) {

//     // get input from request and convert into array

//     // dd($request->all());

//     $var1 = $data['var3'] ?? 0;
//     $var2 = $data['a'] ?? 0;

//     return view('page.modified_welcome', ["totalSum" =>  $var1 * $var2]);
// })->name('welcome3');

Route::get('/student-list', function () {
    $data = DB::select('SELECT * FROM students');
    return response()->json($data);
});

// Day 29 9/9
// Get list of classroom types available
Route::get('classroom-type', function () {
    // Eloquent ORM
    // $data = ClassroomType::all(); // get all rows, as array of object

    $data = ClassroomType::get(); // get all rows, as array of object

    // $data = ClassroomType::first(); // get first rows, as object

    // $data = ClassroomType::find(2); // get based on id, as object, fail return none

    // $data = ClassroomType::findOrFail(5); // fail return model find exception

    // $data = ClassroomType::find()->toSQL(); // to get SQL query executed, will not return data but SQL query

    // $data = ClassroomType::where('type', 'recorded')->get(); // search using 'something', (column name, 'value')

    // $data = ClassroomType::where('type', 'consultation', '%rec%')->get(); // search by 'half value'

    // $data = ClassroomType::where('id', '>=', 2)->get(); // get all row between range of column ids, eg: get all rows with id more/equal than 2

    // /*
    // * DB Query a.k.a Query Builder
    // */
    // $data = DB::table('classroom_types')->first(); /// get first row

    // // sample chain query, multiple conditions
    // $data = DB::table('countries')->where('id', '>', 3)->where('name', 'like', "%us%")->orWhere('name', 'like', '%malaysia')->toSql();
    // $data = DB::table('countries')->where('id', '>', 3)->where('name', 'like', "%us%")->orWhere('name', 'like', '%malaysia')->get();

    // simplifying sample chain query, multiple conditions
    // $data = DB::table('countries')->where(
    //     [
    //         ['id', '>', 3],
    //         ['name', 'like', "%us%"]
    //     ]
    // )->orWhere('name', 'like', '%malaysia')->get();

    // check User.php under model if use created check $fillable
    // User::created([
    //     'name' => "ededed",
    //     'email' => 'wfwefwefwefwe',
    //     'password' => 'fefededada'
    // ]);


    return response()->json($data);
});
