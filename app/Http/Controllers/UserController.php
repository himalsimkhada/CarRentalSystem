<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
    public function update(Request $request): RedirectResponse
    {
        try {
            $id = Crypt::decrypt($request->input('id'));

            $validation = $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'address' => 'required|string',
                'contact' => 'required|string',
                'username' => 'required|' . Rule::unique('users')->ignore($id),
            ]);

            DB::beginTransaction();

            $values = [
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'contact' => $request->input('contact'),
                'username' => $request->input('username'),
            ];

            // Update the user record
            User::where('id', $id)->update($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Edited successfully.']);
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while updating the user: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while updating the user: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while updating the user. Please try again later.']);
        }
    }
    public function updatePicture(Request $request): RedirectResponse
    {
        try {
            $id = Crypt::decrypt($request->input('id'));

            $getprofile = $request->file('profile_photo');
            $extension = $getprofile->extension();
            $img = Image::make($getprofile)->fit(250);
            $filename = auth()->user()->username . '_' . time() . '.' . $extension;
            $path = 'images/profile_images/' . $filename;
            $img->save(public_path($path));

            $validatedData = $request->validate([
                'profile_photo' => 'required|image',
            ]);

            DB::beginTransaction();

            $values = [
                'profile_photo' => $path,
            ];

            // Update the user record with the new profile photo path
            User::where('id', '=', $id)->update($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Profile updated.']);
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while updating the profile picture: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while updating the profile picture: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while updating the profile picture. Please try again later.']);
        }
    }

    public function password(Request $request): RedirectResponse
    {
        try {
            $id = auth()->user()->id;

            if (Hash::check($request->input('old_password'), auth()->user()->password)) {
                $validatedData = $request->validate([
                    'password' => 'required|string|min:8',
                ]);

                DB::beginTransaction();

                $values = [
                    'password' => Hash::make($request->input('password')),
                ];

                // Update the user record with the new hashed password
                User::where('id', '=', $id)->update($values);

                DB::commit();

                return redirect()->back()->with(['type' => 'success', 'message' => 'Password changed.']);
            } else {
                return redirect()->back()->with(['type' => 'error', 'message' => 'Old password doesn\'t match.']);
            }
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while updating the password: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while updating the password: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while updating the password. Please try again later.']);
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
