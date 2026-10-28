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

class ChecksheetFE implements FromView, WithEvents
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
        return view('checksheetexp_fe', [
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
					for($i = 0; $i < count($data[$h]->criteria_details_fe); $i++){
            			$footer_pos = $i + 17;
            			$footer_pos2 = $i + 18;
            			$footer_pos3 = $i + 19;
					}
            	}

                $main_header_border_range_row = 'B2:G2';
                $main_header_border_range_row2 = 'B3:G3';
                $main_header_border_range_row3 = 'H2:L2';
                $main_header_border_range_row4 = 'H3:L3';      

                $secondary_header_border_range_row = 'B5:E5';
                $secondary_header_border_range_row2 = 'B6:E6';
                $secondary_header_border_range_row3 = 'B8:E8';
                $secondary_header_border_range_row4 = 'B9:E9';

                $tertiary_header_border_range_col = 'B11:B13';
                $tertiary_header_border_range_col2 = 'C11:C13'; 
                $tertiary_header_border_range_col3 = 'D11:D13';      
                $tertiary_header_border_range_col4 = 'E11:E13';
                $tertiary_header_border_range_row5 = 'F11:K11';
                $tertiary_header_border_range_col6 = 'F12:F13';
                $tertiary_header_border_range_col7 = 'G12:G13';
                $tertiary_header_border_range_col8 = 'H12:H13';
                $tertiary_header_border_range_row9 = 'I12:J12';
                $tertiary_header_border_range_col9 = 'K12:K13';
                $tertiary_header_border_range_col10 = 'L11:L13';

                $main_footer_border_range_row = 'B'.$footer_pos.':D'.$footer_pos;         
                $main_footer_border_range_row2 = 'B'.$footer_pos2.':D'.$footer_pos2;   
                $main_footer_border_range_row3 = 'B'.$footer_pos3.':D'.$footer_pos3;        

                $main_footer_border_range_row4 = 'E'.$footer_pos.':L'.$footer_pos;         
                $main_footer_border_range_row5 = 'E'.$footer_pos2.':H'.$footer_pos2;   
                $main_footer_border_range_row6 = 'I'.$footer_pos2.':L'.$footer_pos2;
                $main_footer_border_range_row7 = 'E'.$footer_pos3.':H'.$footer_pos3;   
                $main_footer_border_range_row8 = 'I'.$footer_pos3.':L'.$footer_pos3;

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
                $event->sheet->getStyle($tertiary_header_border_range_col4)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_row5)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col6)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_col7)->applyFromArray($styleBorderThin);
                $event->sheet->getStyle($tertiary_header_border_range_col8)->applyFromArray($styleBorderThin);   
                $event->sheet->getStyle($tertiary_header_border_range_row9)->applyFromArray($styleBorderThin); 
                $event->sheet->getStyle($tertiary_header_border_range_col10)->applyFromArray($styleBorderThin);

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
