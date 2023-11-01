<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\DashboardFilter;
use App\Http\Controllers\Controller;
use App\Models\KongLogs;
use DB;
use OpenAdmin\Admin\Admin;
use OpenAdmin\Admin\Controllers\AdminController;
//use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Widgets\Form;
//use App\Admin\Controllers\Form;
use OpenAdmin\Admin\Controllers\Dashboard;
use OpenAdmin\Admin\Layout\Column;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Layout\Row;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis; 

class KongDashboardController extends Controller
{
    public $color = array(
        0 => array("backgroundColor"=>"rgb(0, 91, 187)", "borderColor"=>"rgb(0, 91, 187)"),
        1 => array("backgroundColor"=>"rgb(153, 0, 0)", "borderColor"=>"rgb(153, 0, 0)"),
        2 => array("backgroundColor"=>"rgb(173, 132, 31)", "borderColor"=>"rgb(173, 132, 31)"),
        3 => array("backgroundColor"=>"rgb(109, 160, 75)", "borderColor"=>"rgb(109, 160, 75)"),
        4 => array("backgroundColor"=>"rgb(0, 101, 112)", "borderColor"=>"rgb(0, 101, 112)"),
        5 => array("backgroundColor"=>"rgb(0, 166, 156)", "borderColor"=>"rgb(0, 166, 156)")

        /*
        RGB: 0/91/187
        RGB: 153/0/0
        RGB: 173/132/31
        RGB: 109/160/75
        RGB: 0/101/112
        RGB: 0/166/156
        RGB: 255/199/44
        RGB: 229/106/84
        RGB: 235/236/0
        RGB: 47/159/208
        RGB: 0/47/86
        RGB: 102/102/102
        */
    );
    public function index(Content $content, Request $request)
    {
        $year = session('dashboard.year');
        $month = session('dashboard.month');
        $date = session('dashboard.date');

        if(!$date) $date = date("Y-m-d");
        
		$logs = KongLogs::select(DB::raw("COUNT(*) as count"), DB::raw("TO_CHAR(created_at, 'DD') as month_name"))
			->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
			->groupBy(DB::raw("TO_CHAR(created_at, 'DD')"))
			->pluck('count', 'month_name');

        $labels = $logs->keys();
        $data = $logs->values();

        //dd($labels->toArray());

        $labels11 = [];
        $data11 = [];
        for($i=1;$i<=31;$i++) {
            if(array_search($i, $labels->toArray()) !== false) {
                $t = array_search($i, $labels->toArray());
                $labels11[$i-1] = $i;
                $data11[$i-1] = $data[$t];
                //var_dump($labels[$t]);
                //dd($data[$t]);
            } else {
                //var_dump($i)." => ";
                //var_dump($labels->toArray());
                //echo "<br>";
                $labels11[$i-1] = $i;
                $data11[$i-1] = 0;
            }
        }

        //dd($labels11);

        $logs2 = KongLogs::select(DB::raw("COUNT(*) as count"), DB::raw("TO_CHAR(create_datetime, 'HH24') as hour_name"))
			->whereDate('created_at', $date)
			->groupBy(DB::raw("TO_CHAR(create_datetime, 'HH24')"))
			->pluck('count', 'hour_name'); 

        /*$labels2 = [
            1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24
        ];*/
        $labels2 = $logs2->keys();
        $data2 = $logs2->values();

        //dd($data2);

        //var_dump($labels2->toArray()); exit();
        //dd($logs2->keys()); 7,8
        //var_dump(collect($labels2)); exit();
        //dd($labels2);
        $labels22 = [];
        $data22 = [];
        for($i=0;$i<=23;$i++) {
            if(array_search(str_pad($i,2,'0',STR_PAD_LEFT), $labels2->toArray())!==false) {
                $t = array_search(str_pad($i,2,'0',STR_PAD_LEFT), $labels2->toArray());
                $labels22[$i] = $i;
                $data22[$i] = $data2[$t];
                //var_dump($data2[$t]);
                //dd($data2[$t]);
            } else {
                $labels22[$i] = $i;
                $data22[$i] = 0;
            }
        }

        $logs3 = KongLogs::select(DB::raw("COUNT(*) as count"), DB::raw("TO_CHAR(created_at, 'DD') as month_name"),
        DB::raw("consumer->>'username' as uname"))
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->groupBy(DB::raw("TO_CHAR(created_at, 'DD'), consumer->>'username'"))
        ->pluck('count', 'month_name');

        $logs4 = KongLogs::select(DB::raw("TO_CHAR(created_at, 'DD') as date_name"),
        DB::raw("consumer->>'username' as uname"),
        DB::raw("COUNT(*) as count")
        )
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->groupBy(DB::raw("TO_CHAR(created_at, 'DD'), consumer->>'username'"))        
        ->get()
        ->toArray();        

        $labels3 = $logs3->keys();
        $data3 = $logs3->values();
        $user3 = $logs3->values();
        //dd($data3);

        $labels44 = [];
        $data44 = [];
        $user44 = [];

        foreach($logs4 as $log) {
            $user44[$log["uname"]]["label"] = $log["uname"];
        }
        //var_dump($user44); exit();
        for($i=1;$i<=31;$i++) {
            if(array_search($i, $labels3->toArray()) !== false) {
                $t = array_search($i, $labels3->toArray());
                //echo $i." => ".$data3[$t]."<br>";
                foreach($logs4 as $no => $log) {
                    if($log["date_name"]==$i) {
                        //echo "uname:".$log["uname"]." => date:".$log["date_name"]." => count:".$log["count"]."<br>";
                        $data44[$log["uname"]][$i-1] = $log["count"];
                    }
                }                
            } else {
                foreach($user44 as $user) {
                    $data44[$user["label"]][$i] = 0;
                }
            }
        }

        $i=0;
        foreach($user44 as $u => $val) {
            $color = $this->color[$i];
            //echo $u."<br>";
            $user44[$u]["data"] = array(
                "label" => $u,
                "backgroundColor" => $color['backgroundColor'],
                "borderColor" => $color['borderColor'],
                "data" => $data44[$u]
            );
            $i++;
        }

        //dump($user44);
        //dd($user44);

        $labels33 = [];
        $data33 = [];
        for($i=1;$i<=31;$i++) {
            if(array_search($i, $labels3->toArray()) !== false) {
                $t = array_search($i, $labels3->toArray());
                //$labels33[$i-1] = $i;
                $data33[$i-1] = $data3[$t];
            } else {
                //$labels33[$i-1] = $i;
                $data33[$i-1] = 0;
            }
        }

        //dd($labels33);
        //TO_CHAR(NOW()::date, 'dd/mm/yyyy')
        $lastUrl = KongLogs::select("id", DB::raw("request->>'url' as last_url"))            
        ->whereDate('created_at', $date);     

        $lastAccess = KongLogs::select(DB::raw("consumer->>'username' as uname2"), 
            DB::raw('max(id) as lastid')            
            )            
            ->whereDate('created_at', $date)        
            ->groupBy(DB::raw("consumer->>'username'"));            
       
        $logs5 = KongLogs::select(DB::raw("TO_CHAR(created_at, 'yyyy/mm/dd') as lastdate"),
            DB::raw("kong_logs.consumer->>'username' as uname"),
            DB::raw("COUNT(*) as count"),
            DB::raw("url.last_url")
        )
        ->joinSub($lastAccess, 'access', function ($join) 
        {
            $join->on("kong_logs.consumer->username", '=', 'access.uname2');
        })
        ->joinSub($lastUrl, 'url', function ($join)
        {
            $join->on("access.lastid", '=', 'url.id');
        })
        ->whereDate('created_at', $date)
        ->groupBy(DB::raw("TO_CHAR(created_at, 'yyyy/mm/dd')"),
            DB::raw("consumer->>'username'"),
            "url.last_url"
        )      
        ->orderBy(DB::raw('count(*)'), 'DESC')
        ->get()
        ->toArray();

        //dd(KongLogs::getQueryLog());
        //dd($labels33);
        //dd($logs5);

        //var_dump($logs5);
        //echo "<br><br><br>";
        $data5 = $logs5;    

        return $content
            ->css_file(Admin::asset("open-admin/css/pages/dashboard.css"))
            ->title('Dashboard')
            ->description('Description...')
			->row(function($row) use ($data11, $labels11, $data22, $labels22, $data33, $labels33, $data44, $user44, $data5) {
                //$this->form = new Form(new KongLogs());
                //$form->date("created_at", "Date"); 
                $row->column(12, function (Column $column) { //use ($form) {
                    $DashboardFilter = new DashboardFilter();
                    $column->append($DashboardFilter); 
                });

				$row->column(6, function (Column $column) use ($data11, $labels11) {
                    $column->append(view('kong/chart1', compact('labels11', 'data11')));
                });

				$row->column(6, function (Column $column) use ($data22, $labels22) {
					$column->append(view('kong/chart2', compact('labels22', 'data22')));
				});
				$row->column(6, function (Column $column) use ($data33, $labels33, $data44, $user44) {
					$column->append(view('kong/chart3', compact('labels33', 'data44', 'user44')));
				});
				$row->column(6, function (Column $column) use ($data5) {
					$column->append(view('kong/table1', compact('data5')));
				});                           
			});
            //->view('kong/chart1', compact('labels', 'data'));
    }
}
