<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Survey;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::all();
        return response()->json($responses, 200);
    }

    public function show($id)
    {
        $response = Response::find($id);

        if (!$response) {
            return response()->json(['message' => 'Respuesta no encontrada'], 404);
        }

        return response()->json($response, 200);
    }

    public function showFromSurvey($surveyid)
    {
        // Obtener la encuesta por su ID
        $survey = Survey::findOrFail($surveyid);

        // Obtener el número de respuestas para las preguntas de la encuesta
        $numResponses = Response::whereHas('question', function ($query) use ($survey) {
            $query->where('codienquesta', $survey->codienquesta);
        })->count();

        // Obtener todas las respuestas asociadas a las preguntas de la encuesta
        $responses = Response::whereHas('question', function ($query) use ($survey) {
            $query->where('codienquesta', $survey->codienquesta);
        })->get();


        // Añadir el número de respuestas y las respuestas a los datos de la encuesta
        $survey->numResponses = $numResponses;
        $survey->responses = $responses;

        // Retornar la encuesta con el número de respuestas y las respuestas como respuesta JSON
        return response()->json($survey);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'resposta' => ['required', 'string'],
            'dataresposta' => ['required', 'date'],
            'codipregunta' => ['required', 'integer'],
        ]);
        try {
            $response = Response::create($data);
            return response()->json($response, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $response = Response::find($id);

        if (!$response) {
            return response()->json(['message' => 'Respuesta no encontrada'], 404);
        }

        $data = $request->validate([
            'resposta' => ['required', 'string'],
            'dataresposta' => ['required', 'date'],
            'codipregunta' => ['required', 'integer'],
        ]);

        $response->update($data);

        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        $response = Response::find($id);

        if (!$response) {
            return response()->json(['message' => 'Respuesta no encontrada'], 404);
        }

        $response->delete();

        return response()->json(['message' => 'Respuesta eliminada correctamente'], 200);
    }
}
