<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function GetQuestions()
    {
        $questions = Question::with(['users'])->get();

        return response()->json([
            'message' => 'success',
            'data' => $questions
        ]);
    }

    public function PostQuestions(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'desc' => 'required'
        ]);

        $data['user_id'] = auth('sanctum')->user()->id;

        $question = Question::create($data);

        if($question){
            return response()->json([
                'message' => 'success',
                'data' => $question
            ]);
        }

        return response()->json([
            'message' => 'failed',
            'data' => []
        ]);
    }

    public function ShowQuestion($id)
    {
        $question = Question::query()->with(['users', 'answers', 'answers.users'])->where('id', $id)->first();

        if($question){
            return response()->json([
                'message' => 'success',
                'data' => $question
            ]);
        }

        return response()->json([
            'message' => 'failed',
            'data' => null
        ], 404);
    }
}
