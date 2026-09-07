<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Godparent;

class GodparentSeeder extends Seeder
{
    public function run(): void
    {
        $godparents = [
            [
                'user_id' => null, // Parrain anonyme (pas de compte user)
                'first_name' => 'Jean',
                'last_name' => 'Dupont',
                'email' => 'jean.dupont@example.com',
                'whatsapp' => '+33612345678',
                'address' => '15 Rue de la Paix, 75002 Paris, France',
                'photo' => null,
            ],
            [
                'user_id' => null,
                'first_name' => 'Marie',
                'last_name' => 'Rakoto',
                'email' => 'marie.rakoto@example.com',
                'whatsapp' => '+261345678901',
                'address' => 'Lot IVG 123 Antanimena, Antananarivo 101',
                'photo' => null,
            ],
            [
                'user_id' => null,
                'first_name' => 'Pierre',
                'last_name' => 'Martin',
                'email' => 'pierre.martin@example.com',
                'whatsapp' => '+41791234567',
                'address' => 'Rue du Lac 45, 1201 Genève, Suisse',
                'photo' => null,
            ],
            [
                'user_id' => null,
                'first_name' => 'Sophie',
                'last_name' => 'Andriamampianina',
                'email' => 'sophie.ampianina@example.com',
                'whatsapp' => '+261331234567',
                'address' => 'Bd Andrianampoinimerina, Antsirabe',
                'photo' => null,
            ],
        ];

        foreach ($godparents as $godparent) {
            Godparent::create($godparent);
        }

        $this->command->info('✅ 4 parrains créés avec succès');
    }
}
