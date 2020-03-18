<?php

namespace App\Exports;

use App\Models\cashier\Cashiers;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class SalesReportExport implements FromView, ShouldAutoSize, WithEvents
{

	public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        if($this->type == 'cashier'){
            
            return view('report.sales_report_generate_cashier', [
                'cashiers' => $this->data,
                'start_total' => 0,
                'end_total' => 0
            ]); 

        } elseif($this->type == 'transaction'){
            
            return view('report.sales_report_generate_transaction', [
                'cashiers' => $this->data,
            ]);

        } elseif($this->type == 'product'){
            
            return view('report.sales_report_generate_product', [
                'products' => $this->data,
                'discount' => 0,
                'grand_total' => 0
            ]);

        }
        
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK
		    )
		  )
		);


    	 return [
            AfterSheet::class    => function(AfterSheet $event) use($styleArray) {
                $lastCell  = $event->sheet->getHighestRowAndColumn();
                $cellRange = 'A1:'.$lastCell['column'].$lastCell['row'];
                
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];		
    }

}

