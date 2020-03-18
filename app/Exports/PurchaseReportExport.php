<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class PurchaseReportExport implements FromView, ShouldAutoSize, WithEvents
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
        if($this->type == 'purchase'){
            
            return view('report.purchase_report_generate_purchase', [
                'purchases' => $this->data,
                'total' => 0,
            ]); 

        } elseif($this->type == 'product'){
            
            return view('report.purchase_report_generate_product', [
                'products' => $this->data,
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

