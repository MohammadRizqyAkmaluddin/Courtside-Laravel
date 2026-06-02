<?php

namespace App\Http\Controllers\Api\CSM;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\OperationHour;
use App\Models\Venue;
use App\Models\VenueImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class SettingController extends Controller
{
    public function editName(Request $request)
    {
        $request->validate(['name' => 'required|string']);

        Venue::where('id', Auth::id())
            ->update(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Name'
        ]);
    }

    public function editAddress(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:id,cities',
            'address' => 'required|string',
            'link_map' => 'required|string'
        ]);

        Venue::where('id', Auth::id())
            ->update(['city_id' => $request->city_id])
            ->update(['address' => $request->address])
            ->update(['link_map' => $request->link_map]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Address'
        ]);
    }

    public function editDescription(Request $request)
    {
        $request->validate(['description' => 'required|string']);

        Venue::where('id', Auth::id())
            ->update(['description' => $request->description]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Description'
        ]);
    }

    public function editRules(Request $request)
    {
        $request->validate(['rules' => 'required|string']);

        Venue::where('id', Auth::id())
            ->update(['rules' => $request->rules]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Rules'
        ]);
    }

    public function editPhone(Request $request)
    {
        $request->validate(['phone' => 'required|string']);

        Venue::where('id', Auth::id())
            ->update(['phone' => $request->phone]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Phone'
        ]);
    }

    public function removeFacility(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:id,facilities'
        ]);

        Facility::where('id', $request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully Remove Facility'
        ]);
    }

    public function addFacility(Request $request)
    {
        $request->validate([
            'facility_type_id' => 'required|exists:id,facility_types'
        ]);

        Facility::create([
            'venue_id' => Auth::id(),
            'facility_type_id' => $request->facility_type_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Added New Facility'
        ]);
    }

    public function editOperationalHour(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:id,operation_hours',
            'day_of_week' => 'required|integer|min:1|max:7',
            'is_closed' => 'required|integer|min:0|max:1',
            'open_time' => 'nullable|time',
            'close_time' => 'nullable|time'
        ]);

        $modification = OperationHour::where('id', $request->id)
            ->where('day_of_week', $request->day_of_week);

        $modification->update(['is_closed' => $request->is_closed]);
        $modification->update(['open_time' => $request->open_time]);
        $modification->update(['close_time' => $request->close_time]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Operational Hour'
        ]);
    }

    public function setOpen(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|integer|min:1|max:7'
        ]);

        OperationHour::where('venue_id', Auth::id())
            ->where('day_of_week', $request->day_of_week)
            ->update(['is_closed' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Operational Hour'
        ]);
    }

    public function setClose(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|integer|min:1|max:7'
        ]);

        OperationHour::where('venue_id', Auth::id())
            ->where('day_of_week', $request->day_of_week)
            ->update(['is_closed' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Operational Hour'
        ]);
    }

    public function setTime(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|integer|min:1|max:7'
        ]);

        OperationHour::where('venue_id', Auth::id())
            ->where('day_of_week', $request->day_of_week)
            ->update(['open_time' => $request->open_time])
            ->update(['close_time' => $request->close_time]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully Edit Operational Hour'
        ]);
    }

    public function addImage(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imageName = null;

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $imageName = Str::random(20) . '.' . $extension;
        $file->storeAs('public/venue', $imageName);

        VenueImage::create([
            'venue_id' => Auth::id(),
            'image' => $imageName
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully added image'
        ]);
    }

    public function setPrimary(Request $request)
    {
        VenueImage::where('venue_id', Auth::id())
            ->update(['is_primary' => false]);

        VenueImage::where('id', $request->id)
            ->update(['is_primary' => true]);

        return response()->json([
            'success' => true
        ]);
    }

    public function removeImage(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $image = VenueImage::lockForUpdate()->findOrFail($request->id);

            // Ambil image lain dalam venue yang sama
            $otherImages = VenueImage::where('venue_id', $image->venue_id)
                ->where('id', '!=', $image->id)
                ->lockForUpdate()
                ->get();

            // Kalau yang dihapus primary dan masih ada image lain
            if ($image->is_primary && $otherImages->isNotEmpty()) {

                // Ambil salah satu pengganti
                $newPrimary = $otherImages->first();

                // Set semua jadi false dulu
                VenueImage::where('venue_id', $image->venue_id)
                    ->update(['is_primary' => false]);

                // Set pengganti jadi primary
                $updated = VenueImage::where('id', $newPrimary->id)
                    ->update(['is_primary' => true]);

                // DEBUG kalau update gagal
                if (!$updated) {
                    throw new \Exception('Gagal update primary');
                }
            }

            // Hapus file
            if ($image->image && Storage::disk('public')->exists('venue/' . $image->image)) {
                Storage::disk('public')->delete('venue/' . $image->image);
            }

            // Hapus data
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted image'
            ]);
        });
    }

    public function changeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:venues,email',
            'password' => 'required|min:8'
        ]);


        $venue = Venue::where('id', Auth::id())->first();
        $usedCheck = Venue::where('email', $request->email)->first();

        $passwordValidation = !Hash::check($request->password, $venue->password);

        if ($usedCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Email already registered'
            ]);
        } else if ($passwordValidation) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong password'
            ]);
        }

        Venue::where('id', Auth::id())
            ->update(['email' => $request->email]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully changed email'
        ]);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8'
        ]);

        $venue = Venue::where('id', Auth::id())->first();

        $passwordValidation = !Hash::check($request->old_password, $venue->password);

        if ($passwordValidation) {
            return response()->json([
                'success' => false,
                'message' => 'Old password is wrong'
            ]);
        }

        $new_password = Hash::make($data['new_password']);

        Venue::where('id', Auth::id())
            ->update(['password' => $new_password]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully changed email'
        ]);
    }

    public function accountStatus()
    {
        $venue = Venue::where('id', Auth::id())->first();

        if ($venue->status == 'Active') {
            $venue->update(['status' => 'Deactive']);
        } elseif ($venue->status == 'Deactive') {
            $venue->update(['status' => 'Active']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully Activate/Deactivate account'
        ]);
    }
}
