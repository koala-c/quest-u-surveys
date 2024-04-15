<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions, 200);
    }

    public function show($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['message' => 'Pregunta no encontrada'], 404);
        }

        return response()->json($question, 200);
    }

    public function showFromSurvey($surveyid)
    {
        // Find the survey by its ID
        $survey = Survey::findOrFail($surveyid);

        // Retrieve all questions associated with the survey
        $questions = $survey->questions; // Accessing the questions relationship

        // Return the questions along with their types
        return response()->json($questions, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'enunciat' => ['required', 'string', 'max:255'],
            'tipuspregunta' => ['required'],
            'codienquesta' => ['required', 'integer']
        ]);

        $question = Question::create($data);

        return response()->json($question, 200);
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['message' => 'Pregunta no encontrada'], 404);
        }

        $data = $request->validate([
            'enunciat' => 'required',
            'tipuspregunta' => 'required',
            'codienquesta' => 'required',
        ]);

        $question->update($data);

        return response()->json($question, 200);
    }

    public function destroy($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['message' => 'Pregunta no encontrada'], 404);
        }

        $question->delete();

        return response()->json(['message' => 'Pregunta eliminada correctamente'], 200);
    }
}
