<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Carbon\Carbon; // Serveix per treballar amb dates
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return response()->json($surveys, 200);
    }

    public function show($id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['message' => 'Encuesta no encontrada'], 404);
        }

        return response()->json($survey, 200);
    }

    public function showFromUser($userid) {
        $now = Carbon::now(); // Obté la data i hora actual

        $surveys = Survey::where('codienquestador', $userid)
                    ->where('datavalidesaenq', '>', $now) // Filtra per data de validesa major que ara
                    ->get();

        return response()->json($surveys, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descenquesta' => ['required', 'string'],
            'datavalidesaenq' => ['required', 'date'],
            'datacreacioenq' => ['required', 'date'],
            'codienquestador' => ['required', 'integer'],
        ]);

        $survey = Survey::create($data);

        return response()->json($survey, 201);
    }

    public function update(Request $request, $id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['message' => 'Encuesta no encontrada'], 404);
        }

        $data = $request->validate([
            'descenquesta' => ['required', 'string'],
            'datavalidesaenq' => ['required', 'date'],
            'datacreacioenq' => ['required', 'date'],
            'codienquestador' => ['required', 'integer'],
        ]);

        $survey->update($data);

        return response()->json($survey, 200);
    }

    public function destroy($id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['message' => 'Encuesta no encontrada'], 404);
        }

        $survey->delete();

        return response()->json(['message' => 'Encuesta eliminada correctamente'], 200);
    }
}
