<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\AnswerOption;

class AnswerOptionController extends Controller
{
    public function index()
    {
        // Implement index logic
    }

    public function show($id)
    {
        // Implement show logic
    }

    public function create(Question $question) // Route with question parameter
    {
        return view('answer_options.create', compact('question'));
    }

    public function store(Request $request, Question $question) // Route with question parameter
    {
        $question->answerOptions()->create($request->all());
        return redirect()->route('questions.create', $question->id); // Redirect after creation
    }

    public function update(Request $request, $id)
    {
        // Implement update logic
    }

    public function destroy($id)
    {
        // Implement destroy logic
    }
}
