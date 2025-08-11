<?php

use App\Models\LookupStatusLog;
use Illuminate\Database\Seeder;

class LookupStatusLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'id' => 0,
                'nama' => 'New',
                'deskripsi' => 'New ticket status',
                'color' => '#17a2b8',
                'order' => 0,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'id' => 1,
                'nama' => 'Waiting Reply',
                'deskripsi' => 'Waiting for customer reply',
                'color' => '#ffc107',
                'order' => 1,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'id' => 2,
                'nama' => 'Replied',
                'deskripsi' => 'Staff has replied to the ticket',
                'color' => '#28a745',
                'order' => 2,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'id' => 3,
                'nama' => 'Resolved',
                'deskripsi' => 'Ticket has been resolved',
                'color' => '#6c757d',
                'order' => 3,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'id' => 4,
                'nama' => 'In Progress',
                'deskripsi' => 'Ticket is being worked on',
                'color' => '#007bff',
                'order' => 4,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'id' => 5,
                'nama' => 'On Hold',
                'deskripsi' => 'Ticket is temporarily on hold',
                'color' => '#dc3545',
                'order' => 5,
                'is_active' => true,
                'created_by' => 1,
            ]
        ];

        foreach ($statuses as $status) {
            LookupStatusLog::create($status);
        }
    }
}
