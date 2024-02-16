<?php

 

namespace App\Http\Controllers;

 

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Response;

 

class ExcelController extends Controller

{

    public function export()

    {

        // Array of objects

        $values = [

            (object) ['request_id' => '11111', 'job_title' => '09090', 'name' => '', 'class' => ''],

            (object) ['request_id' => '345', 'job_title' => 'gfb', 'name' => '', 'class' => ''],

            (object) ['request_id' => '54', 'job_title' => '6565', 'name' => '', 'class' => ''],

            (object) ['request_id' => '5665', 'job_title' => '0906590', 'name' => '', 'class' => ''],

        ];

 

        // Create the Excel file

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

 

        // Add column headers

        $sheet->setCellValue('A1', 'Request Id');

        $sheet->setCellValue('B1', 'Job Title');

        $sheet->setCellValue('C1', 'Name');

        $sheet->setCellValue('D1', 'Class');

 

        // Loop through the objects and extract the desired properties

        $row = 2;

        foreach ($values as $value) {

            $sheet->setCellValue('A' . $row, $value->request_id);

            $sheet->setCellValue('B' . $row, $value->job_title);

            $sheet->setCellValue('C' . $row, $value->name);

            $sheet->setCellValue('D' . $row, $value->class);

            $row++;

        }

 

        // Save the Excel file

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $path = storage_path('app/data.xlsx');

        $writer->save($path);

 

        // Prepare the file response

        $headers = [

            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

        ];

 

        return Response::download($path, 'data.xlsx', $headers)->deleteFileAfterSend(true);

    }

}