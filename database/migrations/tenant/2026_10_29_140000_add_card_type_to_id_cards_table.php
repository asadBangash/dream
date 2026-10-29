<?php

use App\Enums\IdCardType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('id_cards')) {
            return;
        }

        if (! Schema::hasColumn('id_cards', 'card_type')) {
            Schema::table('id_cards', function (Blueprint $table) {
                $table->string('card_type', 20)->default(IdCardType::STUDENT)->after('title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('id_cards') && Schema::hasColumn('id_cards', 'card_type')) {
            Schema::table('id_cards', function (Blueprint $table) {
                $table->dropColumn('card_type');
            });
        }
    }
};
