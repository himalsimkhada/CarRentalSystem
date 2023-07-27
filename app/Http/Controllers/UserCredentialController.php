<?php

namespace App\Http\Controllers;

use App\DataTables\UserCredentialsDataTable;
use App\Models\UserCredential;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
    public function store(Request $request): RedirectResponse
    {
        try {
            $user = auth()->user();
            if ($request->hasFile('file') && $request->hasFile('image')) {
                if ($request->file('image')->isValid() && $request->file('file')->isValid()) {
                    $validate_file = $request->validate([
                        'file' => 'mimes:txt,csv,doc,pdf,docx|max:8192',
                        'image' => 'mimes:jpg,png,jpeg|max:8192',
                    ]);

                    DB::beginTransaction();

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

                    // Insert the data into the UserCredential table
                    UserCredential::insert($values);

                    DB::commit();

                    return redirect()->back()->with(['type' => 'success', 'message' => 'Credentials added successfully']);
                } else {
                    return redirect()->back()->with(['type' => 'error', 'message' => 'Invalid file type.']);
                }
            } else {
                return redirect()->back()->with(['type' => 'error', 'message' => 'No files selected.']);
            }
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while storing the user credentials: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while storing the user credentials: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while storing the user credentials. Please try again later.']);
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
    public function update(Request $request): RedirectResponse
    {
        try {
            $id = Crypt::decrypt($request->input('id'));
            $user = auth()->user();

            if ($request->hasFile('file') && $request->hasFile('image')) {
                if ($request->file('image')->isValid() && $request->file('file')->isValid()) {
                    $validate_file = $request->validate([
                        'file' => 'mimes:txt,csv,doc,pdf,docx|max:8192',
                        'image' => 'mimes:jpg,png,jpeg|max:8192',
                    ]);

                    DB::beginTransaction();

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

                    // Update the UserCredential record with the new file and image
                    UserCredential::where('id', '=', $id)->update($values);

                    DB::commit();

                    return redirect()->back()->with(['type' => 'success', 'message' => 'Credentials edited successfully']);
                } else {
                    return redirect()->back()->with(['type' => 'error', 'message' => 'Invalid file type.']);
                }
            } else {
                DB::beginTransaction();

                $values = [
                    'name' => $request->input('name'),
                    'reg_number' => $request->input('reg_number'),
                    'user_id' => $user->id,
                ];

                // Update the UserCredential record without modifying the file and image
                UserCredential::where('id', $id)->update($values);

                DB::commit();

                return redirect()->back()->with(['type' => 'success', 'message' => 'Credentials edited successfully']);
            }
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while updating the user credentials: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while updating the user credentials: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while updating the user credentials. Please try again later.']);
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
