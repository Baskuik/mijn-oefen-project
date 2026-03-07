<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Default waardes zodat de site er meteen hetzelfde uitziet
        $defaults = [
            'hero_title'           => 'Welkom bij de',
            'hero_title_highlight' => 'Pokémon go Webstore',
            'hero_subtitle'        => 'Jouw bestemming voor kwaliteitsproducten. Shop nu en profiteer van gratis verzending vanaf €50!',
            'hero_video_id'        => 'gsuG1HiS-gA',
            'feature_1_title'      => 'Gratis Verzending',
            'feature_1_text'       => 'Vanaf €50 bezorgen we gratis bij je thuis',
            'feature_2_title'      => 'Veilig Betalen',
            'feature_2_text'       => 'Beveiligd met Stripe & SSL encryptie',
            'feature_3_title'      => '24/7 Support',
            'feature_3_text'       => 'Wij staan altijd voor je klaar',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('site_settings')->insert([
                'key'        => $key,
                'value'      => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};