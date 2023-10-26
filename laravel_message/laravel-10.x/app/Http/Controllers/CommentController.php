<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;

class CommentController extends Controller
{
    public function Create(Request $request)
    {
        $user = auth()->user();
        $comment = new Comment([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        $comment->user_id = $user->id;
        $comment->save();
        $responseData = [
            'message' => '評論已新增',
            'comment' => [
                'id' => $comment->id,
                'title' => $comment->title,
                'content' => $comment->content,
                'user_id' => $comment->user_id,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
            ]
        ];
        return response()->json($responseData, 201);
    }
    public function ReadUser()
    {
        $user = auth()->user();
        $userComments = Comment::where('user_id', $user->id)->get();
        return response()->json(['user_comments' => $userComments], 200);
    }

    public function ReadAll()
    {
        $allComments = Comment::all();
        return response()->json(['all_comments' => $allComments], 200);
    }


    public function Update(Request $request, $id)
    {
        $user = auth()->user();

        $comment = Comment::find($id);

        if ($comment && $comment->user_id === $user->id) {

            $comment->title = $request->input('title');
            $comment->content = $request->input('content');
            $comment->save(); // 保存评论的更改到数据库

            $responseData = [
                'message' => '評論已更新',
                'comment' => [
                    'id' => $comment->id,
                    'title' => $comment->title,
                    'content' => $comment->content,
                    'user_id' => $comment->user_id,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at,
                ]
            ];
            return response()->json($responseData, 201);
        } else {
            return response()->json(['message' => '評論不存在或無權限修改'], 403);
        }
    }
    public function Destroy($id)
    {
        $user = auth()->user();
        $comment = Comment::find($id);
        if ($comment && $comment->user_id === $user->id) {
            $comment->delete();
            return response()->json(['message' => '評論已刪除'], 201);
        } else {
            return response()->json(['message' => '評論不存在或無權限刪除'], 403);
        }
    }
    public function SearchUser(Request $request)
    {
        $user = auth()->user();
        $searchKeyword = $request->input('searchKeyword');
        $userComments = Comment::where('user_id', $user->id)
            ->where(function ($query) use ($searchKeyword) {
                $query->where('title', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('content', 'like', '%' . $searchKeyword . '%');
            })
            ->get();
        // $filteredComments = $userComments->filter(function ($comment) use ($searchKeyword) {
        //     return strpos($comment->title, $searchKeyword) !== false || strpos($comment->content, $searchKeyword) !== false;
        // });
        return response()->json(['user_comments' => $userComments], 200);
    }
    public function SearchAll(Request $request)
    {
        $searchKeyword = $request->input('searchKeyword'); // 從前端獲取搜尋關鍵字
        $results = Comment::where('title', 'like', '%' . $searchKeyword . '%')
            ->orWhere('content', 'like', '%' . $searchKeyword . '%')
            ->get();
        return response()->json(['search_results' => $results], 200);
    }
}
