<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::whereApproved(1)->latest()->paginate(20);
        return view('admin.comments.all-comments', [
            'comments' => $comments
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update([
            'approved' => 1
        ]);

        Alert::success('موفق', 'موفقیت آمیز بود');

        return redirect(route('admin.comments.unapproved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        Alert::success('حذف', 'با موفقیت حذف شد');

        return back();
    }

    // other methods
    public function unapproved(Request $request)
    {
        // search box
        $comments = Comment::query();
        if ($keyword = request('search')) {
            $comments->where('comment', 'LIKE', "%{$keyword}%")->orWhereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            });
        }

        $comments = $comments->whereApproved(0)->latest()->paginate(20);
        return view('admin.comments.unapproved', [
            'comments' => $comments
        ]);
    }
}
