<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Gère l'inscription d'un nouvel utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
           
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Optionnel : Générer un token API pour l'utilisateur fraîchement inscrit
        // $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Utilisateur enregistré avec succès.',
            'user' => $user,
            // 'token' => $token, // Si vous voulez retourner le token immédiatement
        ], 201);
    }

    /**
     * Gère la connexion de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants fournis ne correspondent pas à nos enregistrements.'],
            ]);
        }

        $user = Auth::user();

        // Révoquer les tokens existants si vous voulez qu'un seul token soit actif à la fois
        // $user->tokens()->delete();

        // Créer un nouveau token API pour l'utilisateur
        // Pour les applications SPA (comme Angular), nous nous fions au cookie de session,
        // pas à un token Bearer ici, sauf si vous voulez implémenter une logique de token API.
        // Sanctum gère l'authentification SPA via les cookies de session.
        // Si vous utilisez Sanctum pour SPA, vous n'avez pas besoin de générer de token API ici.
        // Le cookie CSRF et le cookie de session suffiront.
        // $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'user' => $user,
            // 'token' => $token, // Supprimez ceci si vous utilisez l'approche SPA de Sanctum
        ]);
    }

    /**
     * Gère la déconnexion de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Pour les applications SPA, il suffit de "révoquer" la session.
        // Sanctum supprimera automatiquement le cookie de session associé.
        Auth::guard('web')->logout(); // Déconnecte la session utilisateur
        $request->session()->invalidate(); // Invalide la session
        $request->session()->regenerateToken(); // Régénère le token CSRF

        // Si vous utilisez aussi des tokens API (par exemple pour une application mobile en plus de l'Angular),
        // vous pourriez vouloir révoquer tous les tokens ou le token actuel.
        // $request->user()->currentAccessToken()->delete(); // Pour révoquer le token actuel si vous l'utilisez

        return response()->json(['message' => 'Déconnexion réussie.']);
    }

    /**
     * Renvoie l'utilisateur actuellement authentifié.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}