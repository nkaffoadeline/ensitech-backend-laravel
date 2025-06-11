<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

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

// Route pour l'utilisateur authentifié.
// Elle est protégée par le middleware 'auth:sanctum', ce qui signifie
// qu'elle ne peut être accédée que si l'utilisateur est authentifié via Sanctum.
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes d'authentification pour l'API.
// Ces routes gèrent l'inscription, la connexion et la déconnexion.
// Elles ne nécessitent généralement PAS le middleware 'web' ici
// car elles sont destinées à des appels API, pas à des sessions web traditionnelles.
// Pour Laravel Sanctum, le cookie CSRF est géré par la route 'sanctum/csrf-cookie'
// qui est une route web par défaut (souvent dans routes/web.php),
// et non par ces routes d'authentification directes dans api.php.
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
// La route '/user' pour l'Auth est généralement protégée et gérée par la route ci-dessus.
// Si AuthController::user() est juste pour obtenir l'utilisateur authentifié,
// la route Route::middleware('auth:sanctum')->get('/user', ...) suffit.
// Si AuthController::user() est pour un autre usage, ajustez son middleware.


// Routes pour la gestion des cours
// Ces routes sont des points d'accès classiques pour les opérations CRUD sur les cours.
// Elles sont accessibles via '/api/courses', '/api/courses/{id}', etc.

// Routes pour la gestion des cours
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
});

// Routes pour la gestion des Teachers
// Route::get('/teachers', [TeacherController::class, 'index']);
// Route::post('/teachers', [TeacherController::class, 'store']);
// Route::put('/teachers/{id}', [TeacherController::class, 'update']);
// Route::delete('/teachers/{id}', [TeacherController::class, 'destroy']);
Route::apiResource('teachers', TeacherController::class);


//routes pour gestion 

