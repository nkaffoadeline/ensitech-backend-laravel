<?php

namespace App\Http\Controllers;

use App\Models\Cours; // Assurez-vous que le nom du modèle correspond à votre classe
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource (Courses).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $courses = Cours::with('teacher')->get();
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
 {
    // 1. Validation des données
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'teacher_id' => 'required|exists:teachers,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'is_published' => 'boolean'
    ]);

    try {
        // 2. Création du cours
        $course = Cours::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'teacher_id' => $validatedData['teacher_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'is_published' => $validatedData['is_published'] ?? false
        ]);

        // 3. Retourne la réponse avec le nouveau cours et le code 201 (Created)
        return response()->json([
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);

    } catch (\Exception $e) {
        // 4. Gestion des erreurs
        return response()->json([
            'message' => 'Failed to create course',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
  public function show($id): JsonResponse
{
    try {
        // Récupère le cours avec ses relations (ex: teacher)
        $course = Cours::with('teacher')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $course
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Course not found'
        ], 404);
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Implémentez la logique de mise à jour
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // Implémentez la logique de suppression
    }
}