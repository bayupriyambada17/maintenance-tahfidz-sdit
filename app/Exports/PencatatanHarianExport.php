<?php

namespace App\Exports;

use App\Models\Harian;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PencatatanHarianExport implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings,ShouldAutoSize,WithStyles
{
    use Exportable;

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        //BORDER
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // HEADER
        $sheet->getStyle("A1:" . $highestColumn . "1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // WRAP TEXT
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getAlignment()->setWrapText(true);

        // ALIGNMENT TEXT
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        //BOLD FIRST ROW
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Nama Musyrif',
            'Surat Awal',
            'Ayat Awal',
            'Surat Akhir',
            'Ayat Akhir',
            // 'Makhroj',
            // 'Tajwid',
            // 'Kelancaran',
            'Total Ayat',
        ];
    }

    public function map($model): array
    {

        return [
            $model->tanggal,
            $model->siswa->name,
            $model->user->name,
            $model->from->name,
            $model->from_ayat,
            $model->to->name,
            $model->to_ayat,
            // $model->makhroj,
            // $model->tajwid,
            // $model->kelancaran,
            $model->total_ayat,
        ];


    }

    public function columnFormats(): array
    {
        return [

        ];
    }

    public function query()
    {
        return Harian::indexHarian();
    }
}
