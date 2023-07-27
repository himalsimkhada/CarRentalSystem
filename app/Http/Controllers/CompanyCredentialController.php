<?php

namespace App\Http\Controllers;

use App\DataTables\CompanyCredentialsDataTable;
use App\Models\CompanyCredential;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CompanyCredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CompanyCredentialsDataTable $dataTable)
    {
        return $dataTable->render('credential.index');
    }

    public function create()
    {
        $credential = new CompanyCredential();
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
        $company_id = auth()->guard('company')->user()->id;
        if ($request->hasFile('file') && $request->hasFile('image')) {
            if ($request->file('image')->isValid() && $request->file('file')->isValid()) {
                try {
                    $validate_file = $request->validate([
                        'file' => 'mimes:txt,csv,doc,pdf,docx|max:8192',
                        'image' => 'mimes:jpg,png,jpeg|max:8192',
                    ]);

                    $extension_file = $validate_file['file']->extension();
                    $file = $validate_file['file']->storeAs('/', auth()->user()->username . '_' . time() . '.' . $extension_file, 'company_credentials');

                    $extension_image = $validate_file['image']->extension();
                    $image = $validate_file['image']->storeAs('/', auth()->user()->username . '_' . time() . '.' . $extension_image, 'company_credentials_images');

                    $values = [
                        'name' => $request->input('name'),
                        'file' => $file,
                        'image' => $image,
                        'reg_number' => $request->input('reg_number'),
                        'company_id' => $company_id,
                    ];

                    DB::beginTransaction();

                    // Perform the data insertion
                    CompanyCredential::insert($values);

                    DB::commit();

                    return redirect()->back()->with(['type' => 'success', 'message' => 'Credential added successfully.']);
                } catch (ValidationException $e) {
                    $errorMessage = $e->getMessage();
                    Log::error("Validation error occurred while adding the credential: $errorMessage");

                    throw $e;
                } catch (\Throwable $e) {
                    DB::rollback();

                    $errorMessage = $e->getMessage();
                    Log::error("Error occurred while adding the credential: $errorMessage");

                    return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while adding the credential. Please try again later.']);
                }
            } else {
                return redirect()->back()->with(['type' => 'error', 'message' => 'Invalid file type.']);
            }
        } else {
            return redirect()->back()->with(['type' => 'error', 'message' => 'Files not selected.']);
        }
    }

    public function edit($id)
    {
        $credential = CompanyCredential::where('id', $id)->first();
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
        $id = Crypt::decrypt($request->input('id'));
        $company = auth()->guard('company')->user();

        try {
            DB::beginTransaction();

            if ($request->hasFile('file') && $request->hasFile('image')) {
                if ($request->file('image')->isValid() && $request->file('file')->isValid()) {
                    $validate_file = $request->validate([
                        'file' => 'mimes:txt,csv,doc,pdf,docx|max:8192',
                        'image' => 'mimes:jpg,png,jpeg|max:8192',
                    ]);

                    $extension_file = $validate_file['file']->extension();
                    $file = $validate_file['file']->storeAs('/', $company->name . '_' . time() . '.' . $extension_file, 'company_credentials');

                    $extension_image = $validate_file['image']->extension();
                    $image = $validate_file['image']->storeAs('/', $company->name . '_' . time() . '.' . $extension_image, 'company_credentials_images');

                    $values = [
                        'name' => $request->input('name'),
                        'file' => $file,
                        'image' => $image,
                        'reg_number' => $request->input('reg_number'),
                        'company_id' => $company->id,
                    ];

                    CompanyCredential::where('id', $id)->update($values);

                    DB::commit();

                    return redirect()->back()->with(['type' => 'success', 'message' => 'Credential added successfully.']);
                } else {
                    return redirect()->back()->with(['type' => 'error', 'message' => 'Invalid file type.']);
                }
            } else {
                $values = [
                    'name' => $request->input('name'),
                    'reg_number' => $request->input('reg_number'),
                    'company_id' => $company->id,
                ];

                CompanyCredential::where('id', $id)->update($values);

                DB::commit();

                return redirect()->back()->with(['type' => 'success', 'message' => 'Successfully edited.']);
            }
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while updating the credential: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while updating the credential: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while updating the credential. Please try again later.']);
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
        $response = CompanyCredential::where('id', '=', $id)->delete();

        return response()->json($response);
    }
}
