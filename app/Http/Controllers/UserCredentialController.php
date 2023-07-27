<?php

namespace App\Http\Controllers;

use App\DataTables\UserCredentialsDataTable;
use App\Models\UserCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserCredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserCredentialsDataTable $dataTable)
    {
        return $dataTable->render('credential.index');
    }

    public function create()
    {
        $credential = new UserCredential();
        return view('credential.create-edit', compact('credential'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($request->hasFile('file') && $request->hasFile('image')) {
            if ($request->file('image')->isValid() && $request->file('file')->isValid()) {
                $validate_file = $request->validate([
                    'file' => 'mimes:txt,csv,doc,pdf,docx|max:8192',
                    'image' => 'mimes:jpg,png,jpeg|max:8192',
                ]);

                $extension_file = $validate_file['file']->extension();
                $file = $validate_file['file']->storeAs('/', $user->username . '_' . time() . '.' . $extension_file, 'user_credentials');

                $extension_image = $validate_file['image']->extension();
                $image = $validate_file['image']->storeAs('/', $user->username . '_' . time() . '.' . $extension_image, 'user_credentials_images');

                $values = [
                    'name' => $request->input('name'),
                    'file' => $file,
                    'image' => $image,
                    'reg_number' => $request->input('reg_number'),
                    'user_id' => $user->id,
                ];

                UserCredential::insert($values);

                return redirect()->back()->with(['type' => 'success', 'message' => 'Credentials added successfully']);
            } else {
                return redirect()->back()->with(['type' => 'error', 'message' => 'Invalid file type.']);
            }
        } else {
            return redirect()->back()->with(['type' => 'error', 'message' => 'No files seleted.']);
        }
    }

    public function edit($id)
    {
        $credential = UserCredential::where('id', $id)->first();
        return view('credential.create-edit', compact('credential'));
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
        $id = Crypt::decrypt($request->input('id'));
        $user = auth()->user();
        if ($request->hasFile('file') && $request->hasFile('image')) {
            if ($request->file('image')->isValid() && $request->file('file')->isValid()) {
                $validate_file = $request->validate([
                    'file' => 'mimes:txt,csv,doc,pdf,docx|max:8192',
                    'image' => 'mimes:jpg,png,jpeg|max:8192',
                ]);

                $extension_file = $validate_file['file']->extension();
                $file = $validate_file['file']->storeAs('/', $user->username . '_' . time() . '.' . $extension_file, 'user_credentials');

                $extension_image = $validate_file['image']->extension();
                $image = $validate_file['image']->storeAs('/', $user->username . '_' . time() . '.' . $extension_image, 'user_credentials_images');

                $values = [
                    'name' => $request->input('name'),
                    'file' => $file,
                    'image' => $image,
                    'reg_number' => $request->input('reg_number'),
                    'user_id' => $user->id,
                ];

                UserCredential::where('id', '=', $id)->update($values);

                return redirect()->back()->with(['type' => 'success', 'message' => 'Credentials added successfully']);
            } else {
                return redirect()->back()->with(['type' => 'error', 'message' => 'Invalid file type.']);
            }
        } else {
            $values = [
                'name' => $request->input('name'),
                'reg_number' => $request->input('reg_number'),
                'user_id' => $user->id,
            ];

            UserCredential::where('id', $id)->update($values);

            return redirect()->back()->with(['type' => 'success', 'message' => 'Credentials edited successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = UserCredential::where('id', '=', $id)->delete();

        return response()->json($response);
    }
}
