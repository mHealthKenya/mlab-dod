<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dashboard;
use DB;
use App\Printer;
use App\Program;
use App\County;
use App\SubCounty;
use App\Facility;
use App\Unit;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        Auth::user()->load('program', 'facility', 'county');

        return view('dashboard.highcharts_dashboard');
    }

    public function printers_dashboard()
    {
        Auth::user()->load('facility', 'county');

        return view('dashboard.highcharts_printers_dashboard');
    }

    public function get_data()
    {
        $data                = [];
        

      
        if (Auth::user()->user_level == 2) {
            $selected_programs = [Auth::user()->program_id];
        }
        if (Auth::user()->user_level == 3) {
            $selected_facilities = [Auth::user()->facility_id];
        }
        if (Auth::user()->user_level == 5) {
            $selected_units = [Auth::user()->unit_id];
        }

        $programs_with_data = Dashboard::select('program_id')->groupBy('program_id');
        
        $counties_with_data = Dashboard::select('county_id')->groupBy('county_id');

        $units_with_data = Dashboard::select('unit_id')->groupBy('unit_id');
        
        $all_programs = Program::select('id', 'name')->whereIn('id', $programs_with_data);
        $all_counties = County::select('id', 'name')->distinct('id')->whereIn('id', $counties_with_data);
        $all_units = Unit::select('id', 'name')->distinct('id')->whereIn('id', $units_with_data);

        $startdate = Dashboard::select('created_at')->orderBy('created_at', 'asc')->first();
        $startdate = Carbon::parse($startdate->created_at)->format('Y-m-d');
        $enddate  = Dashboard::select('created_at')->orderBy('created_at', 'desc')->first();
        $enddate = Carbon::parse($enddate->created_at)->format('Y-m-d');

        $all_records         = Dashboard::whereNotNull('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $sent_records        = Dashboard::whereNotNull('date_sent')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $counties            = Dashboard::distinct('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $units               = Dashboard::distinct('unit_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $facilities          = Dashboard::distinct('mfl_code');
        $programs            = Dashboard::distinct('program_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_records          = Dashboard::where('result_type', 1)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_records         = Dashboard::where('result_type', 2)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_classifications  = Dashboard::where('result_type', 1)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_classifications = Dashboard::where('result_type', 2)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $county_numbers      = Dashboard::selectRaw('county_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $pulled_data      = Dashboard::join('county', 'county.id', '=', 'mlab_data_materialized.county_id')->selectRaw('county.NAME, COUNT ( mlab_data_materialized.created_at ) AS all_results,  count (mlab_data_materialized.date_sent) AS  pulled_results ')
                            ->groupBy('county.name')->orderBy('county.name')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);

        $average_vl_collect_sent_diff = Dashboard::selectRaw('AVG( created_at::DATE - date_collected::DATE)')->where('result_type', '1')->whereRaw('(created_at::DATE - date_collected::DATE) <= ?', [30])
                           ->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $average_eid_collect_sent_diff = DB::table('mlab_data_materialized')->selectRaw('AVG( created_at::DATE - date_collected::DATE)')->where('result_type', '2')
                            ->whereRaw('(created_at::DATE - date_collected::DATE) <= ?', [30])->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
    
        if (!empty($selected_programs)) {
            $all_programs = Program::select('id', 'name')->whereIn('id', $selected_programs);
            $all_units = $all_units->join('mlab_data_materialized', 'unit.id', '=', 'mlab_data_materialized.unit_id')->whereIn('program_id', $selected_programs);
            $all_counties = $all_counties->join('mlab_data_materialized', 'county.id', '=', 'mlab_data_materialized.county_id')->whereIn('unit_id', $selected_units);
            $all_records = $all_records->whereIn('program_id', $selected_programs);
            $sent_records = $sent_records->whereIn('program_id', $selected_programs);
            $units = $units->whereIn('program_id', $selected_programs);
            $counties = $counties->whereIn('program_id', $selected_programs);
            $facilities = $facilities->whereIn('program_id', $selected_programs);
            $programs = $programs->whereIn('program_id', $selected_programs);
            $vl_records = $vl_records->whereIn('program_id', $selected_programs);
            $eid_records = $eid_records->whereIn('program_id', $selected_programs);
            $vl_classifications = $vl_classifications->whereIn('program_id', $selected_programs);
            $eid_classifications = $eid_classifications->whereIn('program_id', $selected_programs);
            $county_numbers = $county_numbers->whereIn('program_id', $selected_programs);
            $unit_numbers = $unit_numbers->whereIn('program_id', $selected_programs);
            $pulled_data = $pulled_data->whereIn('program_id', $selected_programs);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('program_id', $selected_programs);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('program_id', $selected_programs);
        }

        if (!empty($selected_units)) {
            $all_units = $all_units->whereIn('unit_id', $selected_units);
            $all_records = $all_records->whereIn('unit_id', $selected_units);
            $sent_records = $sent_records->whereIn('unit_id', $selected_units);
            $units = $units->whereIn('unit_id', $selected_units);
            $facilities = $facilities->whereIn('unit_id', $selected_units);
            $programs = $programs->whereIn('unit_id', $selected_units);
            $vl_records = $vl_records->whereIn('unit_id', $selected_units);
            $eid_records = $eid_records->whereIn('unit_id', $selected_units);
            $vl_classifications = $vl_classifications->whereIn('unit_id', $selected_units);
            $eid_classifications = $eid_classifications->whereIn('unit_id', $selected_units);
            $county_numbers = $county_numbers->whereIn('unit_id', $selected_units);
            $pulled_data = $pulled_data->whereIn('unit_id', $selected_units);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('unit_id', $selected_units);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('unit_id', $selected_units);
        }

        if (!empty($selected_counties)) {
            $all_counties = $all_counties->whereIn('county_id', $selected_counties);
            $all_records = $all_records->whereIn('county_id', $selected_counties);
            $sent_records = $sent_records->whereIn('county_id', $selected_counties);
            $counties = $counties->whereIn('county_id', $selected_counties);
            $facilities = $facilities->whereIn('county_id', $selected_counties);
            $programs = $programs->whereIn('county_id', $selected_counties);
            $vl_records = $vl_records->whereIn('county_id', $selected_counties);
            $eid_records = $eid_records->whereIn('county_id', $selected_counties);
            $vl_classifications = $vl_classifications->whereIn('county_id', $selected_counties);
            $eid_classifications = $eid_classifications->whereIn('county_id', $selected_counties);
            $county_numbers = $county_numbers->whereIn('county_id', $selected_counties);
            $pulled_data = $pulled_data->whereIn('county_id', $selected_counties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('county_id', $selected_counties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('county_id', $selected_counties);
        }


        if (!empty($selected_facilities)) {
            $all_programs = Program::select('id', 'name')->where('id', Auth::user()->program_id);
            $all_counties = $all_counties->join('mlab_data_materialized', 'county.id', '=', 'mlab_data_materialized.county_id')->whereIn('mfl_code', $selected_facilities);
            $all_records = $all_records->whereIn('mfl_code', $selected_facilities);
            $sent_records = $sent_records->whereIn('mfl_code', $selected_facilities);
            $counties = $counties->whereIn('mfl_code', $selected_facilities);
            $facilities = $facilities->whereIn('mfl_code', $selected_facilities);
            $programs = $programs->whereIn('mfl_code', $selected_facilities);
            $vl_records = $vl_records->whereIn('mfl_code', $selected_facilities);
            $eid_records = $eid_records->whereIn('mfl_code', $selected_facilities);
            $vl_classifications = $vl_classifications->whereIn('mfl_code', $selected_facilities);
            $eid_classifications = $eid_classifications->whereIn('mfl_code', $selected_facilities);
            $county_numbers = $county_numbers->whereIn('mfl_code', $selected_facilities);
            $pulled_data = $pulled_data->whereIn('mfl_code', $selected_facilities);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
        }


        $data["all_counties"]        = $all_counties->get();
        $data["all_programs"]        = $all_programs->get();
        $data["all_units"]           = $all_units->get();
        $data["all_records"]         = $all_records->count();
        $data["sent_records"]        = $sent_records->count();
        $data["counties"]            = $counties->count('county_id');
        $data["facilities"]          = $facilities->count('mfl_code');
        $data["programs"]            = $programs->count('program_id');
        $data["vl_records"]          = $vl_records->count();
        $data["eid_records"]         = $eid_records->count();
        $data["vl_classifications"]  = $vl_classifications->get();
        $data["eid_classifications"] = $eid_classifications->get();
        $data["eid_tat"]             = $average_eid_collect_sent_diff->get();
        $data["vl_tat"]              = $average_vl_collect_sent_diff->get();
        $data["county_numbers"]      = $county_numbers->get();
        $data["pulled_data"]         = $pulled_data->get();
        return $data;
    }

    public function get_filtered_data(Request $request)
    {
        $data                = [];
        
        $selected_programs = $request->programs;
        $selected_units = $request->units;
        $selected_counties = $request->counties;
        $selected_subcounties = $request->subcounties;
        $selected_facilites = $request->facilities;
        $selected_dates = $request->daterange;

        $dates = explode('-', $selected_dates);

        $unformatted_startdate = trim($dates[0]);
        $unformatted_enddate = trim($dates[1]);

        $startdate = Carbon::createFromFormat('m/d/Y', $unformatted_startdate)->format('Y-m-d');
        $enddate = Carbon::createFromFormat('m/d/Y', $unformatted_enddate)->format('Y-m-d');

        if (Auth::user()->user_level == 2) {
            $selected_programs = [Auth::user()->program_id];
        }
        if (Auth::user()->user_level == 3) {
            $selected_facilities = [Auth::user()->facility_id];
        }
        if (Auth::user()->user_level == 5) {
            $selected_units = [Auth::user()->unit_id];
        }
        if (empty($selected_programs)) {
            $programs_with_data = Dashboard::select('program_id')->groupBy('program_id');
        } else {
            $programs_with_data = $selected_programs;
        }
        
        if (empty($selected_units)) {
            $units_with_data = Dashboard::select('unit_id')->groupBy('unit_id');
        } else {
            $units_with_data = $selected_units;
        }

        if (empty($selected_counties)) {
            $counties_with_data = Dashboard::select('county_id')->groupBy('county_id');
        } else {
            $counties_with_data = $selected_counties;
        }
        
        $all_programs = Program::select('id', 'name')->whereIn('id', $programs_with_data);
        $all_units = Unit::select('id', 'name')->distinct('id')->whereIn('id', $units_with_data);
        $all_counties = County::select('id', 'name')->distinct('id')->whereIn('id', $counties_with_data);

        $all_records         = Dashboard::whereNotNull('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $sent_records        = Dashboard::whereNotNull('date_sent')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $units               = Dashboard::distinct('unit_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $counties            = Dashboard::distinct('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $facilities          = Dashboard::distinct('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $programs            = Dashboard::distinct('program_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_records          = Dashboard::where('result_type', 1)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_records         = Dashboard::where('result_type', 2)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_classifications  = Dashboard::where('result_type', 1)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_classifications = Dashboard::where('result_type', 2)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $county_numbers      = Dashboard::selectRaw('county_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $unit_numbers        = Dashboard::selectRaw('unit_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('unit_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $pulled_data      = Dashboard::join('county', 'county.id', '=', 'mlab_data_materialized.county_id')->selectRaw('county.NAME, COUNT ( mlab_data_materialized.created_at ) AS all_results,  count (mlab_data_materialized.date_sent) AS  pulled_results ')
                            ->groupBy('county.name')->orderBy('county.name')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);

        $average_vl_collect_sent_diff = Dashboard::selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '1')->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])
                            ->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $average_eid_collect_sent_diff = DB::table('mlab_data_materialized')->selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '2')
                            ->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
    
        if (!empty($selected_programs)) {
            $all_units = $all_units->join('mlab_data_materialized', 'unit.id', '=', 'mlab_data_materialized.unit_id')->whereIn('program_id', $selected_programs);
            $all_counties = $all_counties->join('mlab_data_materialized', 'county.id', '=', 'mlab_data_materialized.county_id')->whereIn('unit_id', $selected_programs);
            $all_records = $all_records->whereIn('program_id', $selected_programs);
            $sent_records = $sent_records->whereIn('program_id', $selected_programs);
            $counties = $counties->whereIn('program_id', $selected_programs);
            $facilities = $facilities->whereIn('program_id', $selected_programs);
            $programs = $programs->whereIn('program_id', $selected_programs);
            $units = $units->whereIn('program_id', $selected_programs);
            $vl_records = $vl_records->whereIn('program_id', $selected_programs);
            $eid_records = $eid_records->whereIn('program_id', $selected_programs);
            $vl_classifications = $vl_classifications->whereIn('program_id', $selected_programs);
            $eid_classifications = $eid_classifications->whereIn('program_id', $selected_programs);
            $county_numbers = $county_numbers->whereIn('program_id', $selected_programs);
            $pulled_data = $pulled_data->whereIn('program_id', $selected_programs);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('program_id', $selected_programs);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('program_id', $selected_programs);
        }

        if (!empty($selected_units)) {
            $all_counties = $all_counties->whereIn('county_id', $selected_units);
            $all_records = $all_records->whereIn('county_id', $selected_units);
            $sent_records = $sent_records->whereIn('county_id', $selected_units);
            $counties = $counties->whereIn('county_id', $selected_units);
            $facilities = $facilities->whereIn('county_id', $selected_units);
            $programs = $programs->whereIn('county_id', $selected_units);
            $units = $units->whereIn('county_id', $selected_units);
            $vl_records = $vl_records->whereIn('county_id', $selected_units);
            $eid_records = $eid_records->whereIn('county_id', $selected_units);
            $vl_classifications = $vl_classifications->whereIn('county_id', $selected_units);
            $eid_classifications = $eid_classifications->whereIn('county_id', $selected_units);
            $county_numbers = $county_numbers->whereIn('county_id', $selected_units);
            $pulled_data = $pulled_data->whereIn('county_id', $selected_units);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('county_id', $selected_units);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('county_id', $selected_units);
        }

        if (!empty($selected_counties)) {
            $all_counties = $all_counties->whereIn('county_id', $selected_counties);
            $all_records = $all_records->whereIn('county_id', $selected_counties);
            $sent_records = $sent_records->whereIn('county_id', $selected_counties);
            $counties = $counties->whereIn('county_id', $selected_counties);
            $facilities = $facilities->whereIn('county_id', $selected_counties);
            $programs = $programs->whereIn('county_id', $selected_counties);
            $units = $units->whereIn('county_id', $selected_counties);
            $vl_records = $vl_records->whereIn('county_id', $selected_counties);
            $eid_records = $eid_records->whereIn('county_id', $selected_counties);
            $vl_classifications = $vl_classifications->whereIn('county_id', $selected_counties);
            $eid_classifications = $eid_classifications->whereIn('county_id', $selected_counties);
            $county_numbers = $county_numbers->whereIn('county_id', $selected_counties);
            $pulled_data = $pulled_data->whereIn('county_id', $selected_counties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('county_id', $selected_counties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('county_id', $selected_counties);
        }

        if (!empty($selected_subcounties)) {
            $all_counties = $all_counties->whereIn('Sub_County_ID', $selected_subcounties);
            $all_records = $all_records->whereIn('Sub_County_ID', $selected_subcounties);
            $sent_records = $sent_records->whereIn('Sub_County_ID', $selected_subcounties);
            $counties = $counties->whereIn('Sub_County_ID', $selected_subcounties);
            $facilities = $facilities->whereIn('Sub_County_ID', $selected_subcounties);
            $programs = $programs->whereIn('Sub_County_ID', $selected_subcounties);
            $units = $units->whereIn('Sub_County_ID', $selected_subcounties);
            $vl_records = $vl_records->whereIn('Sub_County_ID', $selected_subcounties);
            $eid_records = $eid_records->whereIn('Sub_County_ID', $selected_subcounties);
            $vl_classifications = $vl_classifications->whereIn('Sub_County_ID', $selected_subcounties);
            $eid_classifications = $eid_classifications->whereIn('Sub_County_ID', $selected_subcounties);
            $county_numbers = $county_numbers->whereIn('Sub_County_ID', $selected_subcounties);
            $pulled_data = $pulled_data->whereIn('Sub_County_ID', $selected_subcounties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('Sub_County_ID', $selected_subcounties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('Sub_County_ID', $selected_subcounties);
        }

        if (!empty($selected_facilities)) {
            $all_programs = Program::select('id', 'name')->where('id', Auth::user()->program_id);
            $all_counties = $all_counties->whereIn('mfl_code', $selected_facilities);
            $all_records = $all_records->whereIn('mfl_code', $selected_facilities);
            $sent_records = $sent_records->whereIn('mfl_code', $selected_facilities);
            $counties = $counties->whereIn('mfl_code', $selected_facilities);
            $facilities = $facilities->whereIn('mfl_code', $selected_facilities);
            $programs = $programs->whereIn('mfl_code', $selected_facilities);
            $units = $units->whereIn('mfl_code', $selected_facilites);
            $vl_records = $vl_records->whereIn('mfl_code', $selected_facilities);
            $eid_records = $eid_records->whereIn('mfl_code', $selected_facilities);
            $vl_classifications = $vl_classifications->whereIn('mfl_code', $selected_facilities);
            $eid_classifications = $eid_classifications->whereIn('mfl_code', $selected_facilities);
            $county_numbers = $county_numbers->whereIn('mfl_code', $selected_facilities);
            $pulled_data = $pulled_data->whereIn('mfl_code', $selected_facilities);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
        }


        $data["all_counties"]        = $all_counties->get();
        $data["all_units"]           = $all_units->get();
        $data["all_programs"]        = $all_programs->get();
        $data["all_records"]         = $all_records->count();
        $data["sent_records"]        = $sent_records->count();
        $data["counties"]            = $counties->count('county_id');
        $data["facilities"]          = $facilities->count('mfl_code');
        $data["programs"]            = $programs->count('program_id');
        $data["units"]               = $units->count('unit_id');
        $data["vl_records"]          = $vl_records->count();
        $data["eid_records"]         = $eid_records->count();
        $data["vl_classifications"]  = $vl_classifications->get();
        $data["eid_classifications"] = $eid_classifications->get();
        $data["eid_tat"]             = $average_eid_collect_sent_diff->get();
        $data["vl_tat"]              = $average_vl_collect_sent_diff->get();
        $data["county_numbers"]      = $county_numbers->get();
        $data["pulled_data"]         = $pulled_data->get();
        return $data;
    }

    public function get_printers_data()
    {
        $data                = [];
    

    
        if (Auth::user()->user_level == 3) {
            $selected_facilities = [Auth::user()->facility_id];
        }
        if (Auth::user()->user_level == 5) {
            $selected_units = [Auth::user()->unit_id];
        }

    
        $counties_with_data = Printer::select('county_id')->groupBy('county_id');
        $units_with_data = Printer::select('unit_id')->groupBy('unit_id');
    
        $all_counties = County::select('id', 'name')->distinct('id')->whereIn('id', $counties_with_data);
        $all_units = Unit::select('id', 'name')->distinct('id')->whereIn('id', $units_with_data);

        $startdate = Printer::select('created_at')->orderBy('created_at', 'asc')->first();
        $startdate = Carbon::parse($startdate->created_at)->format('Y-m-d');
        $enddate  = Printer::select('created_at')->orderBy('created_at', 'desc')->first();
        $enddate = Carbon::parse($enddate->created_at)->format('Y-m-d');

        $all_records         = Printer::whereNotNull('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $sent_records        = Printer::whereNotNull('date_sent')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $counties            = Printer::distinct('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $units               = Printer::distinct('unit_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $facilities          = Printer::distinct('mfl_code');
        $vl_records          = Printer::where('result_type', 1)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_records         = Printer::where('result_type', 2)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_classifications  = Printer::where('result_type', 1)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_classifications = Printer::where('result_type', 2)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $county_numbers      = Printer::selectRaw('county_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $pulled_data      = Printer::join('county', 'county.id', '=', 'printers_data.county_id')->selectRaw('county.NAME, COUNT ( printers_data.created_at ) AS all_results,  count (printers_data.date_sent) AS  pulled_results ')
                        ->groupBy('county.name')->orderBy('county.name')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);

        $average_vl_collect_sent_diff = Printer::selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '1')->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])
                        ->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $average_eid_collect_sent_diff = DB::table('printers_data')->selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '2')
                        ->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);

    
        if (!empty($selected_counties)) {
            $all_counties = $all_counties->whereIn('county_id', $selected_counties);
            $all_records = $all_records->whereIn('county_id', $selected_counties);
            $sent_records = $sent_records->whereIn('county_id', $selected_counties);
            $counties = $counties->whereIn('county_id', $selected_counties);
            $facilities = $facilities->whereIn('county_id', $selected_counties);
            $vl_records = $vl_records->whereIn('county_id', $selected_counties);
            $eid_records = $eid_records->whereIn('county_id', $selected_counties);
            $vl_classifications = $vl_classifications->whereIn('county_id', $selected_counties);
            $eid_classifications = $eid_classifications->whereIn('county_id', $selected_counties);
            $county_numbers = $county_numbers->whereIn('county_id', $selected_counties);
            $pulled_data = $pulled_data->whereIn('county_id', $selected_counties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('county_id', $selected_counties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('county_id', $selected_counties);
        }

        if (!empty($selected_units)) {
            $all_counties = $all_counties->whereIn('unit_id', $selected_units);
            $all_records = $all_records->whereIn('unit_id', $selected_units);
            $sent_records = $sent_records->whereIn('unit_id', $selected_units);
            $counties = $counties->whereIn('unit_id', $selected_units);
            $facilities = $facilities->whereIn('unit_id', $selected_units);
            $vl_records = $vl_records->whereIn('unit_id', $selected_units);
            $eid_records = $eid_records->whereIn('unit_id', $selected_units);
            $vl_classifications = $vl_classifications->whereIn('unit_id', $selected_units);
            $eid_classifications = $eid_classifications->whereIn('unit_id', $selected_units);
            $county_numbers = $county_numbers->whereIn('unit_id', $selected_units);
            $pulled_data = $pulled_data->whereIn('unit_id', $selected_units);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('unit_id', $selected_units);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('unit_id', $selected_units);
        }


        if (!empty($selected_facilities)) {
            $all_counties = $all_counties->join('mlab_data_materialized', 'county.id', '=', 'mlab_data_materialized.county_id')->whereIn('mfl_code', $selected_facilities);
            $all_records = $all_records->whereIn('mfl_code', $selected_facilities);
            $sent_records = $sent_records->whereIn('mfl_code', $selected_facilities);
            $counties = $counties->whereIn('mfl_code', $selected_facilities);
            $facilities = $facilities->whereIn('mfl_code', $selected_facilities);
            $vl_records = $vl_records->whereIn('mfl_code', $selected_facilities);
            $eid_records = $eid_records->whereIn('mfl_code', $selected_facilities);
            $vl_classifications = $vl_classifications->whereIn('mfl_code', $selected_facilities);
            $eid_classifications = $eid_classifications->whereIn('mfl_code', $selected_facilities);
            $county_numbers = $county_numbers->whereIn('mfl_code', $selected_facilities);
            $pulled_data = $pulled_data->whereIn('mfl_code', $selected_facilities);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
        }


        $data["all_counties"]        = $all_counties->get();
        $data["all_units"]           = $all_units->get();
        $data["all_records"]         = $all_records->count();
        $data["sent_records"]        = $sent_records->count();
        $data["counties"]            = $counties->count('county_id');
        $data["units"]               = $unts->count('unit_id');
        $data["facilities"]          = $facilities->count('mfl_code');
        $data["vl_records"]          = $vl_records->count();
        $data["eid_records"]         = $eid_records->count();
        $data["vl_classifications"]  = $vl_classifications->get();
        $data["eid_classifications"] = $eid_classifications->get();
        $data["eid_tat"]             = $average_eid_collect_sent_diff->get();
        $data["vl_tat"]              = $average_vl_collect_sent_diff->get();
        $data["county_numbers"]      = $county_numbers->get();
        $data["pulled_data"]         = $pulled_data->get();
        return $data;
    }

    public function get_filtered_printers_data(Request $request)
    {
        $data                = [];
    
        $selected_counties = $request->counties;
        $selected_units = $request->units;
        $selected_subcounties = $request->subcounties;
        $selected_facilites = $request->facilities;
        $selected_dates = $request->daterange;

        $dates = explode('-', $selected_dates);

        $unformatted_startdate = trim($dates[0]);
        $unformatted_enddate = trim($dates[1]);

        $startdate = Carbon::createFromFormat('m/d/Y', $unformatted_startdate)->format('Y-m-d');
        $enddate = Carbon::createFromFormat('m/d/Y', $unformatted_enddate)->format('Y-m-d');

    
        if (Auth::user()->user_level == 3) {
            $selected_facilities = [Auth::user()->facility_id];
        }
        if (Auth::user()->user_level == 5) {
            $selected_units = [Auth::user()->unit_id];
        }
    
    
        if (empty($selected_counties)) {
            $counties_with_data = Printer::select('county_id')->groupBy('county_id');
        } else {
            $counties_with_data = $selected_counties;
        }

        if (empty($selected_units)) {
            $units_with_data = Printer::select('unit_id')->groupBy('unit_id');
        } else {
            $units_with_data = $selected_units;
        }
    
        $all_counties = County::select('id', 'name')->distinct('id')->whereIn('id', $counties_with_data);
        $all_units = Unit::select('id', 'name')->distinct('id')->whereIn('id', $units_with_data);

        $all_records         = Printer::whereNotNull('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $sent_records        = Printer::whereNotNull('date_sent')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $counties            = Printer::distinct('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $units               = Printer::distinct('unit_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $facilities          = Printer::distinct('mfl_code')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_records          = Printer::where('result_type', 1)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_records         = Printer::where('result_type', 2)->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $vl_classifications  = Printer::where('result_type', 1)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $eid_classifications = Printer::where('result_type', 2)->selectRaw('data_key, count("result_type") AS number')->groupBy('result_type', 'data_key')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $county_numbers      = Printer::selectRaw('county_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('county_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $unit_numbers        = Printer::selectRaw('unit_id, count(*) AS results, count(DISTINCT(mfl_code)) as facilities')->groupBy('unit_id')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $pulled_data      = Printer::join('county', 'county.id', '=', 'printers_data.county_id')->selectRaw('county.NAME, COUNT ( printers_data.created_at ) AS all_results,  count (printers_data.date_sent) AS  pulled_results ')
                        ->groupBy('county.name')->orderBy('county.name')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);

        $average_vl_collect_sent_diff = Printer::selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '1')->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])
                        ->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);
        $average_eid_collect_sent_diff = DB::table('printers_data')->selectRaw('AVG( date_sent::DATE - date_collected::DATE)')->where('result_type', '2')
                        ->whereRaw('(date_sent::DATE - date_collected::DATE) <= ?', [30])->whereNotNull('date_sent')->whereNotNull('date_collected')->where('date_collected', '!=', '0000-00-00')->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate);

    
        if (!empty($selected_units)) {
            $all_counties = $all_counties->whereIn('unit_id', $selected_units);
            $all_records = $all_records->whereIn('unit_id', $selected_units);
            $sent_records = $sent_records->whereIn('unit_id', $selected_units);
            $counties = $counties->whereIn('unit_id', $selected_units);
            $facilities = $facilities->whereIn('unit_id', $selected_units);
            $vl_records = $vl_records->whereIn('unit_id', $selected_units);
            $eid_records = $eid_records->whereIn('unit_id', $selected_units);
            $vl_classifications = $vl_classifications->whereIn('unit_id', $selected_units);
            $eid_classifications = $eid_classifications->whereIn('unit_id', $selected_units);
            $county_numbers = $county_numbers->whereIn('unit_id', $selected_units);
            $pulled_data = $pulled_data->whereIn('unit_id', $selected_units);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('unit_id', $selected_units);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('unit_id', $selected_units);
        }

        if (!empty($selected_counties)) {
            $all_counties = $all_counties->whereIn('county_id', $selected_counties);
            $all_records = $all_records->whereIn('county_id', $selected_counties);
            $sent_records = $sent_records->whereIn('county_id', $selected_counties);
            $counties = $counties->whereIn('county_id', $selected_counties);
            $facilities = $facilities->whereIn('county_id', $selected_counties);
            $vl_records = $vl_records->whereIn('county_id', $selected_counties);
            $eid_records = $eid_records->whereIn('county_id', $selected_counties);
            $vl_classifications = $vl_classifications->whereIn('county_id', $selected_counties);
            $eid_classifications = $eid_classifications->whereIn('county_id', $selected_counties);
            $county_numbers = $county_numbers->whereIn('county_id', $selected_counties);
            $pulled_data = $pulled_data->whereIn('county_id', $selected_counties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('county_id', $selected_counties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('county_id', $selected_counties);
        }

        if (!empty($selected_subcounties)) {
            $all_counties = $all_counties->whereIn('Sub_County_ID', $selected_subcounties);
            $all_records = $all_records->whereIn('Sub_County_ID', $selected_subcounties);
            $sent_records = $sent_records->whereIn('Sub_County_ID', $selected_subcounties);
            $counties = $counties->whereIn('Sub_County_ID', $selected_subcounties);
            $facilities = $facilities->whereIn('Sub_County_ID', $selected_subcounties);
            $vl_records = $vl_records->whereIn('Sub_County_ID', $selected_subcounties);
            $eid_records = $eid_records->whereIn('Sub_County_ID', $selected_subcounties);
            $vl_classifications = $vl_classifications->whereIn('Sub_County_ID', $selected_subcounties);
            $eid_classifications = $eid_classifications->whereIn('Sub_County_ID', $selected_subcounties);
            $county_numbers = $county_numbers->whereIn('Sub_County_ID', $selected_subcounties);
            $pulled_data = $pulled_data->whereIn('Sub_County_ID', $selected_subcounties);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('Sub_County_ID', $selected_subcounties);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('Sub_County_ID', $selected_subcounties);
        }

        if (!empty($selected_facilities)) {
            $all_counties = $all_counties->whereIn('mfl_code', $selected_facilities);
            $all_records = $all_records->whereIn('mfl_code', $selected_facilities);
            $sent_records = $sent_records->whereIn('mfl_code', $selected_facilities);
            $counties = $counties->whereIn('mfl_code', $selected_facilities);
            $facilities = $facilities->whereIn('mfl_code', $selected_facilities);
            $vl_records = $vl_records->whereIn('mfl_code', $selected_facilities);
            $eid_records = $eid_records->whereIn('mfl_code', $selected_facilities);
            $vl_classifications = $vl_classifications->whereIn('mfl_code', $selected_facilities);
            $eid_classifications = $eid_classifications->whereIn('mfl_code', $selected_facilities);
            $county_numbers = $county_numbers->whereIn('mfl_code', $selected_facilities);
            $pulled_data = $pulled_data->whereIn('mfl_code', $selected_facilities);
            $average_vl_collect_sent_diff = $average_vl_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
            $average_eid_collect_sent_diff = $average_eid_collect_sent_diff->whereIn('mfl_code', $selected_facilities);
        }


        $data["all_counties"]        = $all_counties->get();
        $data["all_units"]           = $all_units->get();
        $data["all_records"]         = $all_records->count();
        $data["sent_records"]        = $sent_records->count();
        $data["counties"]            = $counties->count('county_id');
        $data["units"]               = $units->count('unit_id');
        $data["facilities"]          = $facilities->count('mfl_code');
        $data["vl_records"]          = $vl_records->count();
        $data["eid_records"]         = $eid_records->count();
        $data["vl_classifications"]  = $vl_classifications->get();
        $data["eid_classifications"] = $eid_classifications->get();
        $data["eid_tat"]             = $average_eid_collect_sent_diff->get();
        $data["vl_tat"]              = $average_vl_collect_sent_diff->get();
        $data["county_numbers"]      = $county_numbers->get();
        $data7["unit_numbers"]       = $ounit_numbers->get();
        $data["pulled_data"]         = $pulled_data->get();
        return $data;
    }


    public function get_dashboard_units(Request $request)
    {
        $program_ids = array();
        $strings_array = $request->programs;
        if (!empty($strings_array)) {
            foreach ($strings_array as $each_id) {
                $program_ids[] = (int) $each_id;
            }
        }
        $units_with_data = Dashboard::select('unit_id')->distinct('unit_id')->groupBy('unit_id')->get();

        if (!empty($program_ids)) {
            $all_units = Unit::join('program','program.id', '=', 'unit.program_id')
                ->join('sub_county', 'county.id', '=', 'sub_county.county_id')
                ->join('health_facilities', 'sub_county.id', '=', 'health_facilities.Sub_County_ID')
                ->select('county.id as id', 'county.name as name')
                ->distinct('county.id')
                ->whereIn('health_facilities.program_id', $program_ids)
                ->whereIn('county.id', $counties_with_data)
                ->groupBy('county.id', 'county.name')
                ->get('county.id');
        } else {
            $all_counties = County::join('sub_county', 'county.id', '=', 'sub_county.county_id')
            ->join('health_facilities', 'sub_county.id', '=', 'health_facilities.Sub_County_ID')
            ->select('county.id as id', 'county.name as name')
            ->distinct('county.id')
            ->whereIn('county.id', $counties_with_data)
            ->groupBy('county.id', 'county.name')
            ->get();
        }
        return $all_counties;
    }

    public function get_dashboard_counties(Request $request)
    {
        $unit_ids = array();
        $strings_array = $request->units;
        if (!empty($strings_array)) {
            foreach ($strings_array as $each_id) {
                $unit_ids[] = (int) $each_id;
            }
        }
        $counties_with_data = Dashboard::select('county_id')->distinct('county_id')->groupBy('county_id')->get();

        if (!empty($unit_ids)) {
            $all_counties = County::join('sub_county', 'county.id', '=', 'sub_county.county_id')
                ->join('health_facilities', 'sub_county.id', '=', 'health_facilities.Sub_County_ID')
                ->select('county.id as id', 'county.name as name')
                ->distinct('county.id')
                ->whereIn('health_facilities.unit_id', $unit_ids)
                ->whereIn('county.id', $counties_with_data)
                ->groupBy('county.id', 'county.name')
                ->get('county.id');
        } else {
            $all_counties = County::join('sub_county', 'county.id', '=', 'sub_county.county_id')
            ->join('health_facilities', 'sub_county.id', '=', 'health_facilities.Sub_County_ID')
            ->select('county.id as id', 'county.name as name')
            ->distinct('county.id')
            ->whereIn('county.id', $counties_with_data)
            ->groupBy('county.id', 'county.name')
            ->get();
        }
        return $all_counties;
    }

    public function get_dashboard_sub_counties(Request $request)
    {
        $county_ids = array();
        $strings_array = $request->counties;
        if (!empty($strings_array)) {
            foreach ($strings_array as $each_id) {
                $county_ids[] = (int) $each_id;
            }
        }
        $sub_counties_with_data = Dashboard::select('Sub_County_ID')->groupBy('Sub_County_ID')->get();
        if (!empty($county_ids)) {
            $all_sub_counties = SubCounty::select('id', 'name')->distinct('id')->wherein('county_id', $county_ids)->wherein('id', $sub_counties_with_data)->groupBy('id', 'name')->get();
        } else {
            $all_sub_counties = SubCounty::select('id', 'name')->distinct('id')->wherein('id', $sub_counties_with_data)->groupBy('id', 'name')->get();
        }
        return $all_sub_counties;
    }

    public function get_dashboard_facilities(Request $request)
    {
        $sub_county_ids = array();
        $strings_array = $request->sub_counties;
        $unit_ids = $request->programs;
        if (!empty($strings_array)) {
            foreach ($strings_array as $each_id) {
                $sub_county_ids[] = (int) $each_id;
            }
        }

        $withResults = Dashboard::select('mfl_code')->groupBy('mfl_code')->get();
     
        $all_facilities = Facility::select('code', 'name')->distinct('code')->wherein('Sub_County_ID', $sub_county_ids)->wherein('program_id', $program_ids)->wherein('code', $withResults)->groupBy('code', 'name')->get();
        
        return $all_facilities;
    }
}
