<?php

namespace App\Admin\Forms;

//App\Admin\Forms\
use Illuminate\Support\Facades\Session;
use OpenAdmin\Admin\Widgets\Form; 
use Illuminate\Http\Request;
 
class DashboardFilter extends Form
{
    /**
     * The form title.
     *
     * @var  string
     */
    public $title = 'Dashboard Filter';

    /**
     * Handle the form request.
     *
     * @param  Request $request
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        //dump($request->all());

        admin_success('Processed successfully.');

        //return back(); 
        //return $request->all(); 
        //{"created_at":"2022-12-24"}
        //return $this->all();
        //{"filter_year":"2022","search_terms":null,"filter_month":"12","filter_date":"2022-12-24"}
        $param = "";
        $year = "";

        if($request->filter_year) {
            $year = $request->filter_year;
            $param = "year=".$year;
        }

        if($request->filter_month) {
            $month = $request->filter_month;
            $param .= "&month=".$month;
        }

        if($request->filter_date) {
            $date = $request->filter_date;
            $param .= "&date=".$date;
        }
        //dd($year);
        Session::put('dashboard.year', $year);
        Session::put('dashboard.month', $month);
        Session::put('dashboard.date', $date);

        return redirect(route("admin.kong-dashboard.index")."?".$param);
    }

    public function edit()
    {
        $this->form();
    }
    /**
     * Build a form here.
     */
    public function form()
    {
        $year = session('dashboard.year');
        $month = session('dashboard.month');
        $date = session('dashboard.date');
        //dump($year);
        //dd($year);

        $this->select('filter_year', "Year")->options(function() {
            $year = [];
            for($i=2020; $i<=date("Y"); $i++) {
                $year[$i] = $i;         
            }
            return $year;
        })
        ->value($year ? $year : date("Y"));

        $this->select('filter_month', "Month")->options(function() {
            $month = [];            
            for ($i_month = 1; $i_month <= 12; $i_month++) { 
                //$selected = ($selected_month == $i_month ? ' selected' : '');
                //echo '<option value="'.$i_month.'"'.$selected.'>'. date('F', mktime(0,0,0,$i_month)).'</option>'."\n";
                $month[$i_month] = "(".$i_month.") ".date('F', mktime(0,0,0,$i_month));
            }
            return $month;
        })
        ->value($month ? $month : date("m"));

        $this->date('filter_date', 'Date')
        ->value($date ? $date : date("Y-m-d"));     
    }

    /**
     * The data of the form.
     *
     * @return  array $data
     */
    public function data()
    {
        return [
            //'name'       => 'John Doe',
            //'email'      => 'John.Doe@gmail.com',
            'created_at' => now(),
        ];
    }
}