<?php

namespace App\Http\Controllers;

use App\Models\AnswerOption;
use Illuminate\Http\Request;

class AnswerOptionController extends Controller
{
    /**
     * Display a listing of the answer options.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answerOptions = AnswerOption::all();
        return response()->json($answerOptions, 200);
    }

    /**
     * Store a newly created answer option in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'question_id' => 'required|exists:questions,id'
        ]);

        $answerOption = AnswerOption::create([
            'content' => $request->content,
            'question_id' => $request->question_id
        ]);

        return response()->json($answerOption, 201);
    }

    /**
     * Display the specified answer option.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $answerOption = AnswerOption::findOrFail($id);
        return response()->json($answerOption, 200);
    }

    /**
     * Update the specified answer option in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'question_id' => 'required|exists:questions,id'
        ]);

        $answerOption = AnswerOption::findOrFail($id);
        $answerOption->content = $request->content;
        $answerOption->question_id = $request->question_id;
        $answerOption->save();

        return response()->json($answerOption, 200);
    }

    /**
     * Remove the specified answer option from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answerOption = AnswerOption::findOrFail($id);
        $answerOption->delete();

        return response()->json(null, 204);
    }
}
