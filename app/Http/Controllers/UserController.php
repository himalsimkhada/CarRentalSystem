<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\Booking;
use App\Models\User;
use App\Models\UserCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }
    public function dashboard()
    {
        $user = auth()->user();
        $credentials = $user->credentials;

        return view('user.dashboard', ['user' => $user, 'credentials' => $credentials]);
    }

    public function edit($id)
    {
        $user = User::where('id', Crypt::decrypt($id))->first();

        return view('user.create-edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Crypt::decrypt(request()->get('id'));

        $validation = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string',
            'username' => 'required|' . Rule::unique('users')->ignore($id),
        ]);

        $values = [
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'address' => $request->input('address'),
            'contact' => $request->input('contact'),
            'username' => $request->input('username'),
        ];
        User::where('id', $id)->update($values);

        return redirect()->back()->with('alert', 'Edited successfully.');
    }

    public function updatePicture(Request $request)
    {
        $id = Crypt::decrypt($request->input('id'));

        $getprofile = $request->file('profile_photo');
        $extension = $getprofile->extension();
        $img = Image::make($getprofile)->fit(250);
        $filename = auth()->user()->username . '_' . time() . '.' . $extension;
        $path = 'images/profile_images/'.$filename;
        $img->save(public_path($path));

        $validatedData = $request->validate([
            'profile_photo' => 'required|image',
        ]);

        $values = [
            'profile_photo' => $path,
        ];
        User::where('id', '=', $id)->update($values);

        return redirect()->back()->with('alert', 'Profile updated.');
    }

    public function password(Request $request)
    {
        $id = auth()->user()->id;
        if (Hash::check($request->input('old_password'), auth()->user()->password)) {
            $validatedData = $request->validate([
                'password' => 'required|string|min:8',
            ]);
            $values = [
                'password' => Hash::make($request->input('password')),
            ];
            User::where('id', '=', $id)->update($values);

            return redirect()->back()->with('alert', 'Password changed');
        } else {
            return redirect()->back()->with('alert', 'Old Password doesnt match.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        $response = $user->where('id', $id)->delete();

        // return redirect()->back()->with('alert', 'User deleted successfully.');
        return response()->json($response);
    }
}
