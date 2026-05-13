<?php

namespace App\Exports;

use App\Models\Alternatif;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithCustomStartCell
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = Alternatif::whereYear('tanggal', $this->tahun);

        if ($this->bulan) {
            $query->whereMonth('tanggal', $this->bulan);
        }

        return $query->orderBy('tanggal', 'asc')->get();
    }

    // mulai tabel dari row 4
    public function startCell(): string
    {
        return 'A4';
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jenis Bencana',
            'Kecamatan',
            'Desa',
            'Kerusakan',
            'Vol. Kerusakan',
            'Kebutuhan',
            'Vol. Kebutuhan',
            'Perkiraan Nilai Kebutuhan Masyarakat',
            'Perkiraan Nilai Kebutuhan Pemerintah',
            'Kewenangan Aset'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,

            Carbon::parse($row->tanggal)->format('d/m/Y'),

            $row->jenis_bencana,
            $row->kecamatan,
            $row->desa,
            $row->jenis_infrastruktur,
            $row->volume_kerusakan . ' ' . $row->satuan_volume,
            $row->nama_proyek,
            $row->volume_kerusakan . ' ' . $row->satuan_volume,
            $row->estimasi_masyarakat,
            $row->estimasi_pemerintah,

            $row->kewenangan_aset === 'Pemerintah'
                ? 'Pemerintah Kabupaten Ponorogo'
                : $row->kewenangan_aset
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ======================
        // JUDUL
        // ======================

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');

        $sheet->setCellValue(
            'A1',
            'REKAP DATA REHABILITASI DAN REKONSTRUKSI'
        );

        // ======================
        // PERIODE
        // ======================

        $periode = 'SEMUA PERIODE';

        if ($this->bulan && $this->tahun) {

            $namaBulan = [
                1 => 'JANUARI',
                2 => 'FEBRUARI',
                3 => 'MARET',
                4 => 'APRIL',
                5 => 'MEI',
                6 => 'JUNI',
                7 => 'JULI',
                8 => 'AGUSTUS',
                9 => 'SEPTEMBER',
                10 => 'OKTOBER',
                11 => 'NOVEMBER',
                12 => 'DESEMBER',
            ];

            $periode = $namaBulan[(int)$this->bulan] . ' ' . $this->tahun;

        } elseif ($this->tahun) {

            $periode = 'TAHUN ' . $this->tahun;
        }

        $sheet->setCellValue(
            'A2',
            'PERIODE ' . $periode
        );

        // ======================
        // STYLE JUDUL
        // ======================

        $sheet->getStyle('A1:A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => 'center'
            ]
        ]);

        // ======================
        // HEADER TABLE
        // ======================

        $sheet->getStyle('A4:L4')->applyFromArray([
            'font' => [
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center'
            ]
        ]);

        // auto filter
        $sheet->setAutoFilter('A4:L4');

        // format rupiah
        $sheet->getStyle('J5:J1000')
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        $sheet->getStyle('K5:K1000')
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        return [];
    }
}