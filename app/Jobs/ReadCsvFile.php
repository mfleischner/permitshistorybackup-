<?php

namespace App\Jobs;

use App\Libraries\ChunkReadFilter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReadCsvFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $inputFileName;
    public $extension;
    public $timeout = 8000;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($inputFileName,$extension)
    {
        $this->inputFileName = $inputFileName;
        $this->extension = $extension;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $spreadsheet = new Spreadsheet();
        $chunkSize = 1000;

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($this->extension));
        $size = filesize($this->inputFileName);
        $reader->setReadDataOnly(true); 
        $reader->setReadEmptyCells(false);
        $reader->setLoadSheetsOnly('Sheet1');
        $chunkValid = $size / 1048576;
        if($chunkValid > 15){
            $chunkFilter = new ChunkReadFilter();
            $reader->setReadFilter($chunkFilter);
            for ($startRow = 1; $startRow <= 40000; $startRow += $chunkSize) {
                $chunkFilter->setRows($startRow,$chunkSize);
                $spreadsheet = $reader->load($this->inputFileName);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                dispatch(new PermitImportData($sheetData));    
            }
        } else {
            $spreadsheet = $reader->load($this->inputFileName);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            dispatch(new PermitImportData($rows));
        }
        File::delete($this->inputFileName);
    }
}
