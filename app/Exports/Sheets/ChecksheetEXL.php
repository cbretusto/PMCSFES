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

class ChecksheetEXL implements FromView, WithEvents
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
        return view('checksheetexp_exl', [
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
					for($i = 0; $i < count($data[$h]->criteria_details_exl); $i++){
            			$footer_pos = $i + 16;
            			$footer_pos2 = $i + 17;
            			$footer_pos3 = $i + 18;
					}
            	}

                $main_header_border_range_row = 'B2:E2';
                $main_header_border_range_row2 = 'B3:E3';
                $main_header_border_range_row3 = 'F2:H2';
                $main_header_border_range_row4 = 'F3:H3';      

                $secondary_header_border_range_row = 'B5:H5';
                $secondary_header_border_range_row2 = 'B6:H6';

                $tertiary_header_border_range_col = 'B10:B12';
                $tertiary_header_border_range_col2 = 'C10:C12'; 
                $tertiary_header_border_range_row3 = 'D8:G8';
                $tertiary_header_border_range_row4 = 'D9:G9';
                $tertiary_header_border_range_row5 = 'D10:G10';
                $tertiary_header_border_range_row6 = 'D11:E11';
                $tertiary_header_border_range_row7 = 'F11:G11';
                $tertiary_header_border_range_col8 = 'H10:H12';

                $main_footer_border_range_row = 'B'.$footer_pos.':D'.$footer_pos;         
                $main_footer_border_range_row2 = 'B'.$footer_pos2.':D'.$footer_pos2;   
                $main_footer_border_range_row3 = 'B'.$footer_pos3.':D'.$footer_pos3;        

                $main_footer_border_range_row4 = 'E'.$footer_pos.':H'.$footer_pos;         
                $main_footer_border_range_row5 = 'E'.$footer_pos2.':F'.$footer_pos2;   
                $main_footer_border_range_row6 = 'G'.$footer_pos2.':H'.$footer_pos2;
                $main_footer_border_range_row7 = 'E'.$footer_pos3.':F'.$footer_pos3;   
                $main_footer_border_range_row8 = 'G'.$footer_pos3.':H'.$footer_pos3;

                $event->sheet->getStyle($main_header_border_range_row)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row2)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row3)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row4)->applyFromArray($styleBorderThin);   

                $event->sheet->getStyle($secondary_header_border_range_row)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($secondary_header_border_range_row2)->applyFromArray($styleBorderThin);   

                $event->sheet->getStyle($tertiary_header_border_range_col)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col2)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_row3)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_row4)->applyFromArray($styleBorderThin); 
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
