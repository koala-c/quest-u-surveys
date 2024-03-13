<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;

class QuestionController extends Controller
{
    public function create(Survey $survey) // Route with survey parameter
    {
        return view('questions.create', compact('survey'));
    }

    public function store(Request $request, Survey $survey) // Route with survey parameter
    {
        $question = $survey->questions()->create($request->all());
        return redirect()->route('surveys.show', $survey->id); // Redirect after creation
    }

    // Add more methods as needed (edit, delete questions)
}
