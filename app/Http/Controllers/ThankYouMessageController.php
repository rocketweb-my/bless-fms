<?php

namespace App\Http\Controllers;

use App\Models\ThankYouMessage;
use Illuminate\Http\Request;

class ThankYouMessageController extends Controller
{
    public function index()
    {
        $data = ThankYouMessage::find(1);
        return view('pages.thank_you_message',compact('data'));
    }

    public function store(Request $request)
    {
        ThankYouMessage::updateOrCreate(
            [
                'id' => 1
            ],
            [
                'message' => $request->message,
            ]);
            flash('Thank You Message Successfully Updated', 'success');
        return redirect()->back();

    }
}
