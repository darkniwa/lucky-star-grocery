<?php

namespace App\Exports;

use App\Models\Remittance;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RemittancesExport
{
    protected $remittances;

    public function __construct($remittances)
    {
        $this->remittances = $remittances;
    }

    // Function to add quotes around each value
    private function add_quotes($value)
    {
        return '"' . str_replace('"', '""', $value) . '"';
    }

    public function export()
    {
        $exportDate = Carbon::now()->format('Ymd_His');

        $csvData = collect([
            ['Reference No', 'Amount', 'Status', 'Payer', 'Collector', 'Remittance Handler', 'Date']
        ]);

        foreach ($this->remittances as $remittance) {
            $csvData->push([
                $remittance->reference_no,
                $remittance->amount,
                $remittance->status,
                $remittance->getPayerUserRelation->display_name ?? '',
                $remittance->getCollectorUserRelation->display_name ?? '',
                $remittance->getRemittanceHandlerUserRelation->display_name ?? '',
                $remittance->created_at->format('Y-m-d H:i:s'), // Adjust the date format as needed
            ]);
        }

        $csvContent = $csvData->map(function ($row) {
            return implode(',', array_map([$this, 'add_quotes'], $row));
        })->implode("\n");

        $filename = 'remittance_data_' . $exportDate . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
