<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route de login
Route::post('/api/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Identifiant ou mot de passe incorrect.'
        ], 401);
    }

    $user = $request->user();

    return response()->json([
        'user' => [
            'name' => $user->name,
            'role' => $user->role,
        ]
    ]);
});

// Route pour récupérer l'utilisateur connecté
Route::get('/api/user', function (Request $request) {
    return response()->json([
        'user' => [
            'name' => $request->user()->name,
            'role' => $request->user()->role,
        ]
    ]);
})->middleware('auth');

// Route de logout
Route::post('/api/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['message' => 'Déconnecté avec succès.']);
});

Route::get('/{any}', function () {
    return view('angular_app.index'); // 'index' corresponds to resources/views/index.blade.php
})->where('any', '.*')->name('home');


// 1. Définissez TOUTES vos routes API Laravel ici en premier.
    // Route::prefix('api')->group(function () {
    //     Route::get('/courses', function () {
    //         return response()->json(['message' => 'Liste des cours de l\'API Laravel']);
    //     });
    //     // ... vos autres routes API
    // });

    // 2. Route de "Catch-All" pour l'application Angular (DOIT ÊTRE LA DERNIÈRE)
    // Elle rend la vue Blade qui contient l'application Angular.
    Route::get('/{any}', function () {
        // Le nom de la vue est 'angular_app.index' car le fichier est dans resources/views/angular_app/index.blade.php
        return view('angular_app.index');
    })->where('any', '.*');
    
    // 2. Route de "Catch-All" pour l'application Angular (TRÈS IMPORTANT : DOIT ÊTRE LA DERNIÈRE)
    // Le navigateur chargera alors l'application Angular, et Angular gérera son propre routage client-side.
    Route::get('/{any}', function () {
        // Chemin vers le fichier index.html généré par Angular dans le dossier public de Laravel.
        // Assurez-vous que le chemin 'angular_app/index.html' est correct par rapport à votre dossier public.
        return file_get_contents(public_path('angular_app/index.html'));
    })->where('any', '.*'); // Le '.*' signifie "tous les caractères après l'URL de base"
    