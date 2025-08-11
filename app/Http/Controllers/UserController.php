<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function profile()
    {
        $user = user();
        $total_ticket = Ticket::where('owner', user()->id)->get()->count();
        $total_resolved = Ticket::where('owner', user()->id)->where('status','3')->get()->count();
        return view('pages.profile', compact('user','total_ticket','total_resolved'));
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        if ($request->email == $user->email)
        {
            if ($request->username == $user->user)
            {
                User::updateOrCreate(
                    [
                        'id' => $request->id
                    ], [
                        'name' => $request->name,
                        'email' => $request->email,
                        'user' => $request->username,
                        'signature' => $request->signature,
                        'afterreply' => $request->afterreply,
                        'autostart' => $request->autostart,
                        'notify_customer_new' => $request->notify_customer_new,
                        'notify_customer_reply' => $request->notify_customer_reply,
                        'show_suggested' => $request->show_suggested,
                        'notify_new_unassigned' => $request->notify_new_unassigned,
                        'notify_new_my' => $request->notify_new_my,
                        'notify_reply_unassigned' => $request->notify_reply_unassigned,
                        'notify_reply_my' => $request->notify_reply_my,
                        'notify_assigned' => $request->notify_assigned,
                        'notify_pm' => $request->notify_pm,
                        'notify_note' => $request->notify_note,
                    ]);

            }else{
                $duplicate_user = User::where('user', $request->username)->first();
                if ($duplicate_user != null){
                    return redirect()->back()->withErrors('Username not unique. Someone already register by using this username');
                }else{
                    User::updateOrCreate(
                        [
                            'id' => $request->id
                        ], [
                        'name' => $request->name,
                        'email' => $request->email,
                        'user' => $request->username,
                        'signature' => $request->signature,
                        'afterreply' => $request->afterreply,
                        'autostart' => $request->autostart,
                        'notify_customer_new' => $request->notify_customer_new,
                        'notify_customer_reply' => $request->notify_customer_reply,
                        'show_suggested' => $request->show_suggested,
                        'notify_new_unassigned' => $request->notify_new_unassigned,
                        'notify_new_my' => $request->notify_new_my,
                        'notify_reply_unassigned' => $request->notify_reply_unassigned,
                        'notify_reply_my' => $request->notify_reply_my,
                        'notify_assigned' => $request->notify_assigned,
                        'notify_pm' => $request->notify_pm,
                        'notify_note' => $request->notify_note,
                    ]);
                }
            }
        }
        else{
            $duplicate_email = User::where('email', $request->email)->first();
            if ($duplicate_email != null){
                return redirect()->back()->withErrors('Email not unique. Someone already register by using this email');
            }else{
                if ($request->username == $user->user)
                {
                    User::updateOrCreate(
                        [
                            'id' => $request->id
                        ], [
                        'name' => $request->name,
                        'email' => $request->email,
                        'user' => $request->username,
                        'signature' => $request->signature,
                        'afterreply' => $request->afterreply,
                        'autostart' => $request->autostart,
                        'notify_customer_new' => $request->notify_customer_new,
                        'notify_customer_reply' => $request->notify_customer_reply,
                        'show_suggested' => $request->show_suggested,
                        'notify_new_unassigned' => $request->notify_new_unassigned,
                        'notify_new_my' => $request->notify_new_my,
                        'notify_reply_unassigned' => $request->notify_reply_unassigned,
                        'notify_reply_my' => $request->notify_reply_my,
                        'notify_assigned' => $request->notify_assigned,
                        'notify_pm' => $request->notify_pm,
                        'notify_note' => $request->notify_note,
                    ]);

                }else{
                    $duplicate_user = User::where('user', $request->username)->first();
                    if ($duplicate_user != null){
                        return redirect()->back()->withErrors('Username not unique. Someone already register by using this username');
                    }else{
                        User::updateOrCreate(
                            [
                                'id' => $request->id
                            ], [
                            'name' => $request->name,
                            'email' => $request->email,
                            'user' => $request->username,
                            'signature' => $request->signature,
                            'afterreply' => $request->afterreply,
                            'autostart' => $request->autostart,
                            'notify_customer_new' => $request->notify_customer_new,
                            'notify_customer_reply' => $request->notify_customer_reply,
                            'show_suggested' => $request->show_suggested,
                            'notify_new_unassigned' => $request->notify_new_unassigned,
                            'notify_new_my' => $request->notify_new_my,
                            'notify_reply_unassigned' => $request->notify_reply_unassigned,
                            'notify_reply_my' => $request->notify_reply_my,
                            'notify_assigned' => $request->notify_assigned,
                            'notify_pm' => $request->notify_pm,
                            'notify_note' => $request->notify_note,
                        ]);
                    }
                }
            }
        }
        flash('Profile Successfully Updated', 'success');
        return redirect()->back();
    }

    public function change_password(Request $request)
    {
        if ($request->new_pass != $request->con_pass)
        {
            return redirect()->back()->withErrors('New Password and Confirm Password did not match');
        }
        else{
            //Change Text Password to Hash - Start//
            $plaintext = $request->old_pass;
            $majorsalt  = '';
            $len = strlen($plaintext);

            for ($i=0;$i<$len;$i++)
            {
                $majorsalt .= sha1(substr($plaintext,$i,1));
            }
            $corehash = sha1($majorsalt);
            //Change Text Password to Hash - End//

            if ($corehash == user()->pass)
            {
                //Change Text Password to Hash - Start//
                $plaintext2 = $request->new_pass;
                $majorsalt2  = '';
                $len = strlen($plaintext2);

                for ($i=0;$i<$len;$i++)
                {
                    $majorsalt2 .= sha1(substr($plaintext2,$i,1));
                }
                $corehash2 = sha1($majorsalt2);
                //Change Text Password to Hash - End//

                $user = user();
                $user->pass = $corehash2;
                $user->save();

                flash('Password Successfully Updated', 'success');
                return redirect()->back();


            }else{
                return redirect()->back()->withErrors('Incorrect Old Password');
            }
        }
    }

    public function profile_picture(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        $image = $request->file('image');

        $resize = Image::make($image)->encode($image->getClientOriginalExtension());

        $hash = md5($resize->__toString());

        $path = "public/profile_pic/{$hash}.{$image->getClientOriginalExtension()}";

        $save = Storage::put($path, $resize);


//        $url = "/" . $path;
//
//        dd($url);
//
//        $img = Image::make($image->path());
//        $final_image = $img->resize(100, 100, function ($constraint) {
//            $constraint->aspectRatio();
//        });
//
//        // Put image to storage
//        $save = Storage::put("public/profile_pic/{$image->hashName()}", $final_image);
//
//
        $user = User();
        $user->profile_picture = $hash.'.'.$image->getClientOriginalExtension();
        $user->save();

        return back();

    }
}
