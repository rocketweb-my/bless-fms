<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use App\Models\Ticket;
class TicketsExport2 implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    protected $dateFrom;
    protected $dateTo;
    protected $categories;
    protected $status;
    protected $priority;

    public function __construct($dateFrom, $dateTo, $categories, $status, $priority)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->categories = $categories;
        $this->status = $status;
        $this->priority = $priority;
    }

    public function query()
    {
        return Ticket::query()
            ->whereBetween('dt', [$this->dateFrom, $this->dateTo])
            ->whereIn('category', $this->categories)
            ->whereIn('status', $this->status)
            ->whereIn('priority', $this->priority);
    }

    // Add these required methods
    public function headings(): array
    {
        return [
            'Tracking ID',
            'Category',
            'Owner',
            'Date Created'
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->trackid,
            $ticket->category?->name ?? '-',
            $ticket->owner?->name ?? '-',
            Carbon::parse($ticket->dt)->format('d-m-Y')
        ];
    }
}
