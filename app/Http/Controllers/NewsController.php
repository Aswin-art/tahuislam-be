<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function GetNews(Request $request)
    {
        $news = News::query();

        if($request->search){
            $news->where('title', 'LIKE', '%' . $request->search . '%')->get();
        }

        return response()->json([
            'message' => 'success',
            'data' => $news
        ]);
    }

    public function ShowQuestion($id)
    {
        $news = News::query()->with('users')->where('id', $id)->first();

        if($news){
            return response()->json([
                'message' => 'success',
                'data' => $news
            ]);
        }

        return response()->json([
            'message' => 'failed',
            'data' => null
        ], 404);
    }

    public function PostNews(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required|file'
        ]);

        $data['image'] = $request->file('image')->store('news');
        $data['user_id'] = auth('sanctum')->user()->id;

        $news = News::create($data);

        if($news){
            return response()->json([
                'message' => 'success',
                'data' => $news
            ]);
        }

        return response()->json([
            'message' => 'failed',
            'data' => []
        ], 400);
    }

    public function EditNews(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required|file'
        ]);

        $data['image'] = $request->file('image')->store('news');
        $data['user_id'] = auth('sanctum')->user()->id;

        $edited_news = News::where('id', $id)->update($data);

        if($edited_news){
            return response()->json([
                'message' => 'success',
                'data' => $edited_news
            ]);
        }

        return response()->json([
            'message' => 'failed',
            'data' => []
        ]);
    }
}
