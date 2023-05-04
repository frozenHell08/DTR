<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EditProfile extends Controller
{
    public function editProfile(Request $request, User $user) {

        $validation = Validator::make($request->all(), [
            'profpic' => ['image', 'nullable', 'max:10024'],
            'firstName' => ['min:2', 'nullable'],
            'lastName' => ['min:2', 'nullable'] ,
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with('status', 'Something went wrong.');
        }

        if (! is_null($request->profpic)) {

            $validation = Validator::make($request->all(), [
                'profpic' => ['image', 'max:10024']
            ]);

            if ($validation->fails()) {
                return redirect()->back()->with('status', 'Error uploading image.');
            }

            if (! is_null($user->profile_picture)) {
                Storage::delete($user->profile_picture);
            }

            $file = $request->file('profpic');

            $filename = $user->lastName . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/images/profile', $filename);

            $user->update(['profile_picture' => $path]);
        }

        if (! is_null($request->firstName)) {
            $user->firstName = $request->firstName;
        }

        if (! is_null($request->lastName)) {
            $user->lastName = $request->lastName;
        }

        if ($user->isDirty()) {
            $user->save();
        }

        return back()->with('status', 'Successfully updated profile.');
    }
}
