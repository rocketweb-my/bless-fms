<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        return view('pages.slider');
    }

    public function upload(Request $request)
    {
        if($request->file('slider')) {
            $this->validate($request, [
                'slider' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $slider = $request->file('slider');
            $hash_name = $slider->hashName();
            $path = $slider->storeAs('public/image/slider',$hash_name);
        }else{
            Slider::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'file_name' => null,
                    'url'       => null,
                ]
            );
            flash('Slider Successfully Removed', 'success');
            return redirect()->back();
        }
        $url = '';

        Slider::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'file_name' => $hash_name,
                'url'       => $path
            ]
        );
        flash('Slider Successfully Uploaded', 'success');
        return redirect()->back();

    }
}
