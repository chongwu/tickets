<?php

namespace App\Http\Controllers;

use App\Report;
use App\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        setlocale(LC_ALL, 'ru_RU.UTF-8');
        return view('report.index');
    }

	public function get(Request $request) {
		$this->validate($request, [
			'year' => 'required|integer|between:2016,2100',
			'month' => 'required|integer|between:1,12'
		]);
		$tickets = Ticket::with(['workType'])->whereStatus(Ticket::COMPLETED)->whereBetween('created_at', [
			date('Y-m-d H:i:s', mktime(0,0,0, Input::get('month'), 1, Input::get('year'))),
			date('Y-m-d H:i:s', mktime(23, 59, 59, Input::get('month'), date('t', mktime(0, 0, 0, Input::get('month'), 1, Input::get('year'))), Input::get('year')))
		])->get();
		Report::getExcelTicketsReport($tickets);
    }

}
