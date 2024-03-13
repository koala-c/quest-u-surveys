<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('surveys.index', compact('surveys'));
    }

    public function show(Survey $survey) // Route with survey parameter
    {
        $survey->load('questions.answerOptions'); // Eager load questions and options
        return view('surveys.show', compact('survey'));
    }

    public function store(Request $request)
    {
        return Survey::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);
        $survey->update($request->all());
        return $survey;
    }

    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->delete();
        return 204;
    }
}
