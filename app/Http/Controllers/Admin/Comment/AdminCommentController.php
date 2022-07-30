<?php

namespace App\Http\Controllers\Admin\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Animal\Animal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Comment\Comment;
use App\Notifications\NewAnswerComment;
use App\Http\Requests\Admin\Comment\AdminCommentRequest;

class AdminCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'نظرات';
        $comments = Comment::orderBy('id', 'desc')->paginate(20);
        return view('admin.comment.index', compact('comments', 'pageTitle'));
    }

    public function unseenComment()
    {
        $pageTitle = 'نظرات خوانده نشده';
        $comments = Comment::where('seen' , 0)->orderBy('id', 'desc')->paginate(20);
        return view('admin.comment.index', compact('comments', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $comment->seen = 1;
        $comment->save();
        return view('admin.comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comment.index')->with('swal-success', 'نظر با موفقیت حذف شد');
    }


    public function status(Comment $comment)
    {
        // change status and show/hide comment in site
        $comment->status = $comment->status == 0 ? 1 : 0;
        $result = $comment->save();

        // send notification to the user who write parent comment
        if ($comment->parent_id !== null && $comment->status == 1) {
            $user   = $comment->answerUser;
            $answerUser = $comment->user->fullName;
            $details = ['message' => $answerUser . ' به نظر شما پاسخ داد'];
            $user->notify(new NewAnswerComment($details));
        }
        // send response to blade
        if ($result) {
            if ($comment->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function answer(AdminCommentRequest $request, Comment $comment)
    {
        $flag = DB::transaction(function () use ($request, $comment) {
            $commentAnswer = Comment::updateOrCreate(
                [
                    'author_id'        => 1,
                    'parent_id'        => $comment->id,
                    'commentable_id'   => $comment->commentable_id,
                    'commentable_type' => $comment->commentable_type,
                    'status'           => 1,
                    'admin_answer'     => $comment->id,
                ],
                [
                    'body'            => $request->body,
                    'seen'             => 1
                ]
            );
            $comment->status = 1;
            $comment->save();
            return true;
        });
        if ($flag == true) {
            return redirect()->route('admin.comment.index')->with('swal-success', '  پاسخ شما با موفقیت ثبت شد');
        }
    }

    public function readAll()
    {
        $unseenComments = Comment::where('seen', 0)->get();
        foreach ($unseenComments as $unseenComment) {
            $unseenComment->seen = 1;
            $unseenComment->save();
        }

        return to_route('admin.comment.index')->with('swal-success', 'همه ی نظرات خوانده شد');
    }
}
