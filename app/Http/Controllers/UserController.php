<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\UserCredential;
use Illuminate\Http\Request;
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
    public function index()
    {
        $user = auth()->user()->id;

        $details = User::with('credentials')->where('id', '=', $user)->get();

        $credentials = UserCredential::with('user')->where('user_id', '=', $user)->get();

        return view('/user/dashboard', ['user_detail' => $details, 'credentials' => $credentials]);
    }

    public function reservation()
    {
        $user_id = auth()->user()->id;

        $srtPaid = Booking::select('cars.id AS car_id', 'bookings.id AS booking_id', 'users.email AS user_email', 'booking_types.name AS type_name', 'cars.model', 'bookings.date', 'bookings.return_date', 'bookings.final_cost', 'bookings.payment')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('locations', 'locations.id', '=', 'bookings.location_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->where('users.id', '=', $user_id)
            ->orderBy('payment', 'DESC')
            ->get();

        $srtUnpaid = Booking::select('cars.id AS car_id', 'bookings.id AS booking_id', 'users.email AS user_email', 'booking_types.name AS type_name', 'cars.model', 'bookings.date', 'bookings.return_date', 'bookings.final_cost', 'bookings.payment')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('locations', 'locations.id', '=', 'bookings.location_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->where('users.id', '=', $user_id)
            ->orderBy('payment', 'ASC')
            ->get();

        $reservation_details = Booking::select('cars.id AS car_id', 'bookings.id AS booking_id', 'users.email AS user_email', 'booking_types.name AS type_name', 'cars.model', 'bookings.date', 'bookings.return_date', 'bookings.final_cost', 'bookings.payment')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('locations', 'locations.id', '=', 'bookings.location_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->where('users.id', '=', $user_id)
            ->get();

        return view('/user/reservation', ['reservations' => $reservation_details, 'srtUnpaid' => $srtUnpaid, 'srtPaid' => $srtPaid]);
    }

    public function editProfile()
    {
        $user_id = auth()->user()->id;

        $user_details = User::where('id', '=', $user_id)->get();

        return view('/edit/edit-profile', ['details' => $user_details]);
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
        $id = auth()->user()->id;

        $validatedData = $request->validate([
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
            'username' => $request->input('username')
        ];
        User::where('id', '=', $id)->update($values);

        return redirect()->back()->with('alert', 'Edited successfully.');
    }

    public function updatePicture(Request $request)
    {
        $id = auth()->user()->id;

        $getprofile = $request->file('profile_photo');
        $extension = $getprofile->extension();
        $img = Image::make($getprofile)->fit(250);
        $path = public_path('images\profile_images');
        $filename = auth()->user()->username . '_' . time() . '.' . $extension;
        $img->save($path . '/' . $filename);

        $validatedData = $request->validate([
            'profile_photo' => 'required|image',
        ]);

        $values = [
            'profile_photo' => $filename
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
                'password' => Hash::make($request->input('password'))
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
        $user->where('id', '=', $id)->delete();

        return redirect()->back()->with('alert', 'User deleted successfully.');
    }
}
