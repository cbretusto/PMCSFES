<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;


class Checksheet implements FromView, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('checksheetexp', [
            'data' => $this->data,
        ]);
    }

    //for designs
    public function registerEvents(): array
    {
        $styleBorderThin = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ]
            ]
        ];

        $data = $this->data;

        return [
            AfterSheet::class => function(AfterSheet $event) use ($data,$styleBorderThin) {

            	$footer_pos = '';
            	$footer_pos2 = '';
            	$footer_pos3 = '';

            	for($h = 0; $h < count($data); $h++){
					for($i = 0; $i < count($data[$h]->criteria_details); $i++){
            			$footer_pos = $i + 16;
            			$footer_pos2 = $i + 17;
            			$footer_pos3 = $i + 18;
					}
            	}

                $main_header_border_range_row = 'B2:D2';
                $main_header_border_range_row2 = 'B3:D3';
                $main_header_border_range_row3 = 'E2:G2';
                $main_header_border_range_row4 = 'E3:G3';      

                $secondary_header_border_range_row = 'B5:G5';
                $secondary_header_border_range_row2 = 'B6:G6';

                $tertiary_header_border_range_col = 'B11:B12';
                $tertiary_header_border_range_col2 = 'C11:C12'; 
                $tertiary_header_border_range_col3 = 'C11:C12';     
                $tertiary_header_border_range_col4 = 'D11:D12';     
                $tertiary_header_border_range_row5 = 'E11:F11';   
                $tertiary_header_border_range_row6 = 'E9:F9';   
                $tertiary_header_border_range_row7 = 'E10:F10'; 
                $tertiary_header_border_range_col8 = 'G11:G12';  

                $main_footer_border_range_row = 'B'.$footer_pos.':C'.$footer_pos;         
                $main_footer_border_range_row2 = 'B'.$footer_pos2.':C'.$footer_pos2;   
                $main_footer_border_range_row3 = 'B'.$footer_pos3.':C'.$footer_pos3;        

                $main_footer_border_range_row4 = 'D'.$footer_pos.':G'.$footer_pos;         
                $main_footer_border_range_row5 = 'D'.$footer_pos2.':E'.$footer_pos2;   
                $main_footer_border_range_row6 = 'F'.$footer_pos2.':G'.$footer_pos2;
                $main_footer_border_range_row7 = 'D'.$footer_pos3.':E'.$footer_pos3;   
                $main_footer_border_range_row8 = 'F'.$footer_pos3.':G'.$footer_pos3;

                $event->sheet->getStyle($main_header_border_range_row)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row2)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row3)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row4)->applyFromArray($styleBorderThin);   

                $event->sheet->getStyle($secondary_header_border_range_row)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($secondary_header_border_range_row2)->applyFromArray($styleBorderThin);   

                $event->sheet->getStyle($tertiary_header_border_range_col)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col2)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_col3)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col4)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_row5)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_row6)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_row7)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col8)->applyFromArray($styleBorderThin);   

                $event->sheet->getStyle($main_footer_border_range_row)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_footer_border_range_row2)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_footer_border_range_row3)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_footer_border_range_row4)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_footer_border_range_row5)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_footer_border_range_row6)->applyFromArray($styleBorderThin);       
                $event->sheet->getStyle($main_footer_border_range_row7)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_footer_border_range_row8)->applyFromArray($styleBorderThin);                         
            },
        ];
    }
}
