<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

use App\Exports\Sheets\ChecksheetFE;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ChecksheetExportFE implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

   	protected $records;
    protected $checksheet_inspector;
    protected $checksheet_supervisor;
    protected $checksheet_manager; 

    function __construct($records,$checksheet_inspector,$checksheet_supervisor,$checksheet_manager)
    {
        $this->records = $records;
        $this->checksheet_inspector = $checksheet_inspector;
        $this->checksheet_supervisor = $checksheet_supervisor;
        $this->checksheet_manager = $checksheet_manager;
    }

    public function view(): View
    {
    	$checksheet = $this->records;  
        $checksheet_inspector = $this->checksheet_inspector;
        $checksheet_supervisor = $this->checksheet_supervisor;  
        $checksheet_manager = $this->checksheet_manager;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ChecksheetFE($this->records);

        return $sheets;
    }
}
