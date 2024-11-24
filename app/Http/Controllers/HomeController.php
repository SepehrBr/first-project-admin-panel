<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }

    public function comment(Request $request)
    {
        /*
        if (!$request->ajax()) {
            return response()->json([
                'status' => 'just ajax requests are being accepted.'
            ]);
            // برای استفاده از این مدل درخواست همونطور که در فایل بلید مربوطه یادت هست باید هدرز و کانتینت تایپ براش قرار بدیم وگرنه همینطوری معمولی ارسال میکنه
        }*/

        $validData = $request->validate([
        'commentable_id' => ['required'],
        'commentable_type' => ['required'],
        'parent_id' => ['required'],
        'comment' => ['required'],
        ]);

        auth()->user()->comments()->create($validData);

        Alert::success('Success!', 'Comment Successfully sent!');

        return back();
    }
}
