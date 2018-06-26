<?php

namespace App\Http\Controllers;

use App\Jobs\Users\UpdateImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('users.settings');
    }

    public function update(Request $request)
    {
        if ($request->file('image')) {
            $file = $request->file('image');

            if($uuid = Storage::disk('tmp')->putFile('/', $file)){
                $this->dispatch(new UpdateImage(auth()->user(), $uuid, $file->getClientOriginalName()));
            }

        }

        return redirect()->back();
    }
}
