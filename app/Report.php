<?php

namespace App;

use Excel;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class Report {

	public static function getExcelTicketsReport( Collection $tickets ) {
		$grouped = $tickets->groupBy(function(Ticket $item){
			return $item->specialists->first()->name;
		})->map(function(Collection $item){
			return $item->groupBy(function (Ticket $item) {
				return $item->workType->name;
			});
		})->toArray();
		Excel::create('Report', function (LaravelExcelWriter $excel) use ($grouped) {
			$excel->sheet('Заявки', function (LaravelExcelWorksheet $sheet) use ($grouped) {
				$sheet->loadView('report._tickets', ['grouped' => $grouped]);
			});
		})->export('xls');
	}
}