<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TicketType;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticketTypes = [
            [
                'name' => 'Berkaitan Borang Permohonan',
                'name_en' => 'Application Form Related',
                'name_ms' => 'Berkaitan Borang Permohonan',
                'description' => 'Tickets related to application forms',
                'order' => 1,
                'is_active' => 1,
            ],
            [
                'name' => 'Berkaitan Proses',
                'name_en' => 'Process Related',
                'name_ms' => 'Berkaitan Proses',
                'description' => 'Tickets related to processes',
                'order' => 2,
                'is_active' => 1,
            ],
            [
                'name' => 'Berkaitan Profail',
                'name_en' => 'Profile Related',
                'name_ms' => 'Berkaitan Profail',
                'description' => 'Tickets related to profile',
                'order' => 3,
                'is_active' => 1,
            ],
            [
                'name' => 'Berkaitan status permohonan',
                'name_en' => 'Application Status Related',
                'name_ms' => 'Berkaitan status permohonan',
                'description' => 'Tickets related to application status',
                'order' => 4,
                'is_active' => 1,
            ],
            [
                'name' => 'Tidak berkaitan/lain-lain',
                'name_en' => 'Unrelated/Others',
                'name_ms' => 'Tidak berkaitan/lain-lain',
                'description' => 'Unrelated or other tickets',
                'order' => 5,
                'is_active' => 1,
            ],
        ];

        foreach ($ticketTypes as $type) {
            // Check if ticket type already exists
            $exists = TicketType::where('name', $type['name'])->first();

            if (!$exists) {
                TicketType::create($type);
            }
        }

        echo "Ticket Types seeded successfully!\n";
    }
}
