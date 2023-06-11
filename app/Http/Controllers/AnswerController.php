<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function ChangeAnswerStatus($id)
    {
        $answer = Answer::find($id);

        if($answer){
            $answer->correct = true;
            $answer->save();

            $question = Question::find($answer->question_id);
            $question->solved = true;
            $question->save();

            return response()->json([
                'message' => 'success',
                'data' => []
            ]);
        }else{
            return response()->json([
                'message' => 'failed',
                'data' => []
            ], 400);
        }
    }

    public function PostAnswers(Request $request, $id)
    {
        $data = $request->validate([
            'answer' => 'required'
        ]);

        $check = Question::query()->where('id', $id)->where('user_id', auth('sanctum')->user()->id)->first();

        if(!$check){
            $make_answer = Answer::create([
                'answer' => $data['answer'],
                'correct' => false,
                'question_id' => $id,
                'user_id' => auth('sanctum')->user()->id
            ]);
    
            if($make_answer){
                return response()->json([
                    'message' => 'success',
                    'data' => $make_answer
                ]);
            }
        }

        return response()->json([
            'message' => 'failed',
            'data' => []
        ], 400);

    }
}
