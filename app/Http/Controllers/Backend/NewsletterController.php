<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class NewsletterController extends Controller
{
    public function NewsletterList()
    {
        $newsletters = Newsletter::latest()->paginate(20);
        return view('backend.newsletter.list', compact('newsletters'));
    }

    public function NewsletterDelete($id)
    {
        Newsletter::findOrFail($id)->delete();
        return back()->with('success', 'Subscriber deleted successfully.');
    }

    public function NewsletterBulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Newsletter::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true, 'message' => 'Selected subscribers deleted.']);
    }

    public function ToggleStatus(Request $request)
    {
        $newsletter = Newsletter::findOrFail($request->id);
        $newsletter->status = $newsletter->status === 'active' ? 'unsubscribed' : 'active';
        $newsletter->save();

        return response()->json([
            'success' => true,
            'status' => $newsletter->status,
            'message' => $newsletter->status === 'active' ? 'Subscriber activated successfully.' : 'Subscriber unsubscribed successfully.',
        ]);
    }

    public function NewsletterExport()
    {
        $subscribers = Newsletter::orderBy('subscribed_at', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Subscribers');

        // ── Title Row ─────────────────────────────────────────────────
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'Newsletter Subscribers — ' . now()->format('d M Y'));
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0D3B6E'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(40);

        // ── Sub-info Row ──────────────────────────────────────────────
        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', 'Total: ' . $subscribers->count() . '  |  Active: ' . $subscribers->where('status', 'active')->count() . '  |  Exported: ' . now()->format('d M Y, h:i A'));
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 10,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F3864'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(22);

        // ── Column Headers (Row 3) ────────────────────────────────────
        $headers = ['S/N', 'Email Address', 'Status', 'Subscribed At', 'Remarks'];
        foreach ($headers as $col => $header) {
            $cell = Coordinate::stringFromColumnIndex($col + 1) . '3';
            $sheet->setCellValue($cell, $header);
        }
        $sheet->getStyle('A3:E3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF2E75B6'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFB0C4DE'],
                ],
            ],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(28);

        // ── Data Rows ─────────────────────────────────────────────────
        foreach ($subscribers as $i => $sub) {
            $row = $i + 4;
            $isEven = $i % 2 === 0;
            $bgColor = $isEven ? 'FFF0F7FF' : 'FFFFFFFF';

            $sheet->setCellValue("A{$row}", $i + 1);
            $sheet->setCellValue("B{$row}", $sub->email);
            $sheet->setCellValue("C{$row}", ucfirst($sub->status));
            $sheet->setCellValue("D{$row}", $sub->subscribed_at ? $sub->subscribed_at->format('d M Y, h:i A') : '—');
            $sheet->setCellValue("E{$row}", $sub->status === 'active' ? '✔ Active' : '✘ Unsubscribed');

            // Row background
            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $bgColor],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FFD9E1F2'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Status cell color
            if ($sub->status === 'active') {
                $sheet->getStyle("C{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FF1A7F37']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE6F4EA']],
                ]);
                $sheet
                    ->getStyle("E{$row}")
                    ->getFont()
                    ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF1A7F37'));
            } else {
                $sheet->getStyle("C{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FF9E2A2B']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFDECEA']],
                ]);
                $sheet
                    ->getStyle("E{$row}")
                    ->getFont()
                    ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF9E2A2B'));
            }

            // Center S/N and Status columns
            $sheet
                ->getStyle("A{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet
                ->getStyle("C{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet
                ->getStyle("E{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($row)->setRowHeight(22);
        }

        // ── Column Widths ─────────────────────────────────────────────
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(38);
        $sheet->getColumnDimension('C')->setWidth(16);
        $sheet->getColumnDimension('D')->setWidth(28);
        $sheet->getColumnDimension('E')->setWidth(20);

        // ── Freeze header rows ────────────────────────────────────────
        $sheet->freezePane('A4');

        // ── Output ────────────────────────────────────────────────────
        $filename = 'newsletter_subscribers_' . now()->format('Y_m_d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
