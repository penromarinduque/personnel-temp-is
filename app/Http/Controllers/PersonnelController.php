<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PersonnelController extends Controller
{
    //
    public function index() {
        $personnels = UserInfo::query()->where("is_active", 1)->paginate(30);
        $inactivePersonnels = UserInfo::query()->where("is_active", 0)->paginate(30);
        return view('pages.personnel.index', [
            'personnels' => $personnels,
            'inactivePersonnels' => $inactivePersonnels
        ]);
    }

    public function edit($id) {
        $id = Crypt::decryptString($id);
        $personnel = UserInfo::query()->where("userID", $id)->first();
        return view('pages.personnel.edit', [
            'personnel' => $personnel
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            "userID" => "required",
            "badgeNumber" => "nullable|required_if:status,SPES,OJT,Work Immersion Student|numeric",
            "dahua_id" => "nullable|required_if:status,COS,Permanent|numeric",
            "division" => "required|in:main,tsd,pamo",
            "contact" => "nullable|numeric",
            "SSN" => "nullable|required_if:status,Permanent",
            "first_name" => "required|max:50",
            "last_name" => "required|max:50",
            "middle_initial" => "nullable|max:50",
            "ext_name" => "nullable|max:4",
            "gender" => "nullable|in:M,F",
            "position" => "required|max:50",
            "address" => "nullable|max:255",
            "tin" => "nullable|required_if:status,COS|max:20",
            "monthly_rate" => "nullable",
            "daily_rate" => "nullable",
            "hourly_rate" => "nullable",
            "pap" => "nullable|required_if:status,COS|max:100",
            "status" => "required|in:Permanent,COS,OJT,SPES,Work Immersion Student|max:200",
            "is_active" => "required|in:0,1",
        ]);
        
        return DB::transaction(function () use ($request) {
            UserInfo::where("userID", $request->id)->update([
                "userID" => $request->id,
                "badgeNumber" => $request->badgeNumber,
                "dahua_id" => $request->dahua_id,
                "division" => $request->division,
                "position" => $request->position,
                "contact" => $request->contact ? $request->contact : 0,
                "SSN" => $request->SSN,
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "middle_initial" => $request->middle_initial,
                "ext_name" => $request->ext_name,
                "name" => $request->first_name . " " . $request->middle_initial . ". " . $request->last_name . " " . $request->ext_name,
                "gender" => $request->gender,
                "address" => $request->address ? $request->address : "",
                "tin" => $request->tin,
                "monthly_rate" => $request->monthly_rate,
                "daily_rate" => $request->daily_rate,
                "hourly_rate" => $request->hourly_rate,
                "pap" => $request->pap,
                "status" => $request->status,
                "is_active" => $request->is_active
            ]);
            return redirect()->route('personnels.index')->with('success', 'Personnel updated successfully');
        });
    }

    public function create(){
        return view('pages.personnel.create');
    }

    public function store(Request $request){
        $request->validate([
            "userID" => "required",
            "badgeNumber" => "nullable|required_if:status,SPES,OJT,Work Immersion Student|numeric",
            "dahua_id" => "nullable|required_if:status,COS,Permanent|numeric",
            "division" => "required|in:main,tsd,pamo",
            "SSN" => "nullable|required_if:status,Permanent",
            "first_name" => "required|max:50",
            "last_name" => "required|max:50",
            "middle_initial" => "nullable|max:50",
            "ext_name" => "nullable|max:4",
            "gender" => "nullable|in:M,F",
            "position" => "required|max:50",
            "contact" => "nullable|numeric",
            "address" => "nullable|max:255",
            "tin" => "nullable|required_if:status,COS|max:20",
            "monthly_rate" => "nullable",
            "daily_rate" => "nullable",
            "hourly_rate" => "nullable",
            "pap" => "nullable|required_if:status,COS|max:100",
            "status" => "required|in:Permanent,COS,OJT,SPES,Work Immersion Student|max:200",
            "is_active" => "required|in:0,1",
        ]);
        
        return DB::transaction(function () use ($request) {
            $userId = UserInfo::max('userID') + 1;
            UserInfo::create([
                "userID" => $request->userID,
                "badgeNumber" => $request->badgeNumber ? $request->badgeNumber : 0,
                "dahua_id" => $request->dahua_id,
                "division" => $request->division,
                "contact" => $request->contact ? $request->contact : 0,
                "SSN" => $request->SSN ? $request->SSN : 0,
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "middle_initial" => $request->middle_initial,
                "ext_name" => $request->ext_name,
                "name" => $request->first_name . " " . $request->middle_initial . ". " . $request->last_name . " " . $request->ext_name,
                "gender" => $request->gender,
                "address" => $request->address ? $request->address : "",
                "hiredday" => 0,
                "tin" => $request->tin,
                "position" => $request->position,
                "monthly_rate" => $request->monthly_rate,
                "daily_rate" => $request->daily_rate,
                "hourly_rate" => $request->hourly_rate,
                "pap" => $request->pap,
                "status" => $request->status,
                "is_active" => $request->is_active
            ]);
            return redirect()->route('personnels.index')->with('success', 'Personnel created successfully');
        });
    }
}
