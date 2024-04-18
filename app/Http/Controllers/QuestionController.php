<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use \Illuminate\Support\Facades\DB;

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
            'coditipus' => ['required', 'integer'],
            'codienquesta' => ['required', 'integer'],
            'esopcio' => ['required', 'boolean']
        ]);

        try {
            $question = Question::create($data);

            return response()->json($question, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['message' => 'Pregunta no encontrada'], 404);
        }

        $data = $request->validate([
            'enunciat' => 'required',
            'coditipus' => 'required',
            'codienquesta' => 'required',
            'esopcio' => 'required',
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

    public function answerOptions($questionid)
    {
        try {
            // Obté les opcions de resposta per a la pregunta amb l'identificador questionid
            $answerOptions = DB::table('opcio_resposta')
                ->select('descripcio')
                ->join('pregunta_opcio_resposta', 'opcio_resposta.codiopcio', '=', 'pregunta_opcio_resposta.codiopcio')
                ->where('pregunta_opcio_resposta.codipregunta', $questionid)
                ->get();

            // Retorna les opcions de resposta com a resposta de l'endpoint
            return response()->json($answerOptions);
        } catch (\Exception $e) {
            // En cas d'error, retorna una resposta d'error
            return response()->json(['error' => 'No s\'han pogut obtenir les opcions de resposta.'], 500);
        }
    }

}
