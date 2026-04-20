<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DtrOption;
use App\Models\DtrSchedule;
use App\Models\User;
use App\Models\UserInfo;
use Faker\Provider\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DtrScheduleController extends Controller
{
    //
    public function index(Request $request)
    {
        $personnel = $request->has("personnel") ? UserInfo::where("userID", $request->personnel)->first() : UserInfo::first();
        $personnels = UserInfo::where("is_active", 1)
        ->whereIn("status", ["Permanent", "COS"])
        ->get();
        $dtrOptions = DtrOption::all();
        $employmentStatuses = UserInfo::query()->select("status")->distinct()->get();

        if(!$personnel) {
            $scheduleFcEvents = collect();
            $dtrSchedules = collect();
        }
        else {
            $dtrSchedules = DtrSchedule::where("userinfo_id", $personnel->userID)->get();
            $scheduleFcEvents = $dtrSchedules->map(function ($dtrSchedule) {
                return [
                    'id' => $dtrSchedule->id,
                    'title' => $dtrSchedule->dtrOption->description,
                    'start' => $dtrSchedule->start_date,
                    'end' => $dtrSchedule->end_date,
                    'backgroundColor' => $dtrSchedule->dtrOption->color,
                    'schedule' => $dtrSchedule
                ];
            });
        }

        return view('pages.dtr-settings.schedules.index', [
            'personnels' => $personnels,
            'personnel' => $personnel,
            'dtrSchedules' => $dtrSchedules,
            'scheduleFcEvents' => $scheduleFcEvents,
            "dtrOptions" => $dtrOptions,
            "employmentStatuses" => $employmentStatuses
        ]);
    }

    public function apiGetSchedule(Request $request) {
        $schedule = DtrSchedule::query()
        ->with([
            'dtrOption'
        ])
        ->where("id", $request->id)->first();
        return $schedule;
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'dtr_option' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'updateDtrSchedule')->withInput($request->all());
        }

        // check for conflicting schedules
        $_schedule = DtrSchedule::find($request->id);
        $schedule = DtrSchedule::query()
        ->where("id", "!=", $request->id)
        ->where("userinfo_id", $_schedule->userinfo_id)
        ->where(function ($q) use ($request) {
            $q->whereBetween("start_date", [$request->start_date, $request->end_date])
            ->orWhereBetween("end_date", [$request->start_date, $request->end_date]);
        })->first();
        if($schedule) {
            return redirect()->back()->with('error', 'Schedule already exists or overlaps.');
        }

        $schedule = DtrSchedule::query()
        ->where("id", $request->id)->first();
        $schedule->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'dtr_option_id' => $request->dtr_option
        ]);
        return redirect()->back()->with('success', 'Successfully updated schedule.');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'dtr_option' => 'required',
            'user_info_id' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'addDtrSchedule')->withInput($request->all());
        }

        // check for conflicting schedules
        $schedule = DtrSchedule::query()
        ->where("userinfo_id", $request->userinfo_id)
        ->where(function ($q) use ($request) {
            $q->whereBetween("start_date", [$request->start_date, $request->end_date])
            ->orWhereBetween("end_date", [$request->start_date, $request->end_date]);
        })->first();
        if($schedule) {
            return redirect()->back()->with('error', 'Schedule already exists or overlaps.');
        }

        // check for conflicting schedules
        DtrSchedule::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'dtr_option_id' => $request->dtr_option,
            'userinfo_id' => $request->user_info_id
        ]);
        return redirect()->back()->with('success', 'Successfully added schedule.');
    }

    public function delete(Request $request, $id) {
        $schedule = DtrSchedule::find($id);
        $schedule->delete();
        return redirect()->back()->with('success', 'Successfully deleted schedule.');
    }

    public function bulkCreate(Request $request){
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'dtr_option' => 'required',
            'employment_status' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'bulkCreateDtrSchedule')->withInput($request->all());
        }
        
        // check for conflicting schedules
        $schedule = DtrSchedule::query()
        ->whereHas("personnel", function ($q) use ($request) {
            $q->where("status", $request->employment_status);
        })
        ->where(function ($q) use ($request) {
            $q->whereBetween("start_date", [$request->start_date, $request->end_date])
            ->orWhereBetween("end_date", [$request->start_date, $request->end_date]);
        })->first();
        if($schedule) {
            return redirect()->back()->with('error', 'There is a schedule overlap with the selected employment status.');
        }

        $personnels = UserInfo::where("status", $request->employment_status)->get();
        
        $_scheds = $personnels->map(function ($personnel) use ($request) {
            return [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'dtr_option_id' => $request->dtr_option,
                'userinfo_id' => $personnel->userID
            ];
        });

        DtrSchedule::insert($_scheds->toArray());

        return redirect()->back()->with('success', 'Successfully added schedule.');
    }
}
