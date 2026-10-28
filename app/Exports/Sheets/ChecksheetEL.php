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


class ChecksheetEL implements FromView, WithEvents
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
        return view('checksheetexp_el', [
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
					for($i = 0; $i < count($data[$h]->criteria_details_el); $i++){
            			$footer_pos = $i + 19;
            			$footer_pos2 = $i + 20;
            			$footer_pos3 = $i + 21;
					}
            	}

                $main_header_border_range_row = 'B2:I2';
                $main_header_border_range_row2 = 'B3:I3';
                $main_header_border_range_row3 = 'J2:K2';
                $main_header_border_range_row4 = 'J3:K3';      

                $secondary_header_border_range_row = 'B5:K5';
                $secondary_header_border_range_row2 = 'B6:K6';
                $secondary_header_border_range_row3 = 'B8:D8';
                $secondary_header_border_range_row4 = 'B9:D9';

                $tertiary_header_border_range_col = 'B12:B15';
                $tertiary_header_border_range_col2 = 'C12:C15'; 
                $tertiary_header_border_range_col3 = 'D12:D15';      
                $tertiary_header_border_range_row4 = 'E12:G12';
                $tertiary_header_border_range_col5 = 'E13:E14';
                $tertiary_header_border_range_col6 = 'F13:F14';
                $tertiary_header_border_range_col7 = 'G13:G14';
                $tertiary_header_border_range_row8 = 'H12:I12';
                $tertiary_header_border_range_col9 = 'H12:H13';
                $tertiary_header_border_range_col10 = 'H14:H15';
                $tertiary_header_border_range_col11 = 'I14:I15';
                $tertiary_header_border_range_col12 = 'J12:J15';
                $tertiary_header_border_range_col13 = 'K12:K15';

                $main_footer_border_range_row = 'B'.$footer_pos.':D'.$footer_pos;         
                $main_footer_border_range_row2 = 'B'.$footer_pos2.':D'.$footer_pos2;   
                $main_footer_border_range_row3 = 'B'.$footer_pos3.':D'.$footer_pos3;        

                $main_footer_border_range_row4 = 'E'.$footer_pos.':K'.$footer_pos;         
                $main_footer_border_range_row5 = 'E'.$footer_pos2.':H'.$footer_pos2;   
                $main_footer_border_range_row6 = 'I'.$footer_pos2.':K'.$footer_pos2;
                $main_footer_border_range_row7 = 'E'.$footer_pos3.':H'.$footer_pos3;   
                $main_footer_border_range_row8 = 'I'.$footer_pos3.':K'.$footer_pos3;

                $event->sheet->getStyle($main_header_border_range_row)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row2)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row3)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($main_header_border_range_row4)->applyFromArray($styleBorderThin);   

                $event->sheet->getStyle($secondary_header_border_range_row)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($secondary_header_border_range_row2)->applyFromArray($styleBorderThin);   
                $event->sheet->getStyle($secondary_header_border_range_row3)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($secondary_header_border_range_row4)->applyFromArray($styleBorderThin);  

                $event->sheet->getStyle($tertiary_header_border_range_col)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col2)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_col3)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_row4)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_col5)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col6)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_col7)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_row8)->applyFromArray($styleBorderThin);   
                $event->sheet->getStyle($tertiary_header_border_range_col9)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_col10)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col11)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_col12)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col13)->applyFromArray($styleBorderThin);  

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
