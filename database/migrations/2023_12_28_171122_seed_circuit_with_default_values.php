<?php

use App\Models\Circuit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Circuit::create([
            'name' => 'bahrain international circuit',
            'grand_prix' => 'GP Bahrain',
            'started_at' => '2024-2-24 00:00:00',
            'stopped_at' => '2024-3-3 00:00:00'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       $circuit=Circuit::first();
       $circuit->delete();
    }
};
