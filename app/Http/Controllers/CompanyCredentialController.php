<?php

namespace App\Http\Controllers;

use App\Models\CarCompany;
use App\Models\CompanyCredential;
use Illuminate\Http\Request;

class CompanyCredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $company_id = CarCompany::where('owner_id', '=', $user_id)->first()->id;

        $credentials = CompanyCredential::where('company_id', '=', $company_id)->get();
        return view('company.credential', ['credentials' => $credentials]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $company_id = CarCompany::where('owner_id', '=', $user_id)->first()->id;
        if ($request->hasFile('credential_file') && $request->hasFile('image')) {
            if ($request->file('image')->isValid() && $request->file('credential_file')->isValid()) {
                $validate_file = $request->validate([
                    'credential_file' => 'mimes:txt,csv,doc,pdf,docx|max:8192',
                    'image' => 'mimes:jpg,png,jpeg|max:8192'
                ]);        

                $extension_file = $validate_file['credential_file']->extension();
                $file = $validate_file['credential_file']->storeAs('/', auth()->user()->username . '_' . time() . '.' . $extension_file, 'company_credentials');

                $extension_image = $validate_file['image']->extension();
                $image = $validate_file['image']->storeAs('/', auth()->user()->username . '_' . time() . '.' . $extension_image, 'company_credentials_images');

                $values = [
                    'credential_name' => $request->input('name'),
                    'credential_file' => $file,
                    'image' => $image,
                    'credential_id' => $request->input('type_number'),
                    'company_id' => $company_id
                ];

                CompanyCredential::insert($values);

                return redirect()->back()->with('alert', 'Successfull');
            } else {
                return redirect()->back()->with('alert', 'Invalid file types');
            }
        } else {
            return redirect()->back()->with('alert', 'Files not selected');
        }
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
        $user_id = auth()->user()->id;
        $company_id = CarCompany::where('owner_id', '=', $user_id)->first()->id;
        if ($request->hasFile('credential_file') && $request->hasFile('image')) {
            if ($request->file('image')->isValid() && $request->file('credential_file')->isValid()) {
                $validate_file = $request->validate([
                    'credential_file' => 'mimes:txt,csv,doc,pdf,docx|max:8192',
                    'image' => 'mimes:jpg,png,jpeg|max:8192'
                ]);


                $extension_file = $validate_file['credential_file']->extension();
                $file = $validate_file['credential_file']->storeAs('/', auth()->user()->username . '_' . time() . '.' . $extension_file, 'company_credentials');

                $extension_image = $validate_file['image']->extension();
                $image = $validate_file['image']->storeAs('/', auth()->user()->username . '_' . time() . '.' . $extension_image, 'company_credentials_images');

                $values = [
                    'credential_name' => $request->input('name'),
                    'credential_file' => $file,
                    'image' => $image,
                    'credential_id' => $request->input('type_number'),
                    'company_id' => $company_id
                ];

                CompanyCredential::where('id', '=', $request->get('id'))->update($values);

                return redirect()->back()->with('alert', 'Successfull');
            } else {
                return redirect()->back()->with('alert', 'Invalid file types');
            }
        } else {
            return redirect()->back()->with('alert', 'Files not selected');
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
        $delete = CompanyCredential::where('id', '=', $id)->delete();

        if ($delete = true) {
            return redirect()->back()->with('alert', 'Deleted Successfully');
        } else {
            return redirect()->back()->with('alert', 'Delete failed');
        }
    }
}
