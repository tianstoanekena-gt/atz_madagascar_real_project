<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sponsorship;
use App\Models\Student;
use App\Models\Godparent;

class SponsorshipSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les élèves et parrains
        $students = Student::all();
        $godparents = Godparent::all();

        // Créer des sponsorships pour tester les relations
        $sponsorships = [
            // Voahirana a reçu 250 000 Ar de Jean Dupont (validé)
            [
                'student_id' => $students->where('first_name', 'Voahirana')->first()->id,
                'godparent_id' => $godparents->where('first_name', 'Jean')->first()->id,
                'amount' => 250000,
                'payment_status' => 'validated',
                'payment_proof' => null,
                'message' => 'Bon courage dans tes études ! Je crois en toi.',
                'validated_by' => null,
                'validated_at' => now()->subDays(10),
            ],
            // Tiana a complété son objectif grâce à Marie Rakoto (validé)
            [
                'student_id' => $students->where('first_name', 'Tiana')->first()->id,
                'godparent_id' => $godparents->where('first_name', 'Marie')->first()->id,
                'amount' => 600000,
                'payment_status' => 'validated',
                'payment_proof' => null,
                'message' => 'Félicitations pour ton parcours ! Continue ainsi.',
                'validated_by' => null,
                'validated_at' => now()->subMonth(),
            ],
            // Mialy a reçu 800 000 Ar de Pierre Martin (validé)
            [
                'student_id' => $students->where('first_name', 'Mialy')->first()->id,
                'godparent_id' => $godparents->where('first_name', 'Pierre')->first()->id,
                'amount' => 800000,
                'payment_status' => 'validated',
                'payment_proof' => null,
                'message' => 'Tu seras un excellent médecin ! Bonne chance.',
                'validated_by' => null,
                'validated_at' => now()->subDays(20),
            ],
            // Koto a reçu 150 000 Ar de Sophie (validé)
            [
                'student_id' => $students->where('first_name', 'Koto')->first()->id,
                'godparent_id' => $godparents->where('first_name', 'Sophie')->first()->id,
                'amount' => 150000,
                'payment_status' => 'validated',
                'payment_proof' => null,
                'message' => 'Continue à travailler dur avec le bois !',
                'validated_by' => null,
                'validated_at' => now()->subDays(5),
            ],
            // Faly a une demande en attente de Jean Dupont (pending)
            [
                'student_id' => $students->where('first_name', 'Faly')->first()->id,
                'godparent_id' => $godparents->where('first_name', 'Jean')->first()->id,
                'amount' => 100000,
                'payment_status' => 'pending',
                'payment_proof' => null,
                'message' => 'Je veux aider ce jeune garçon courageux.',
                'validated_by' => null,
                'validated_at' => null,
            ],
        ];

        foreach ($sponsorships as $sponsorship) {
            Sponsorship::create($sponsorship);
        }

        // Mettre à jour les montants collectés des élèves
        foreach ($students as $student) {
            $totalCollected = $student->sponsorships()
                ->where('payment_status', 'validated')
                ->sum('amount');

            $student->update(['collected_amount' => $totalCollected]);
        }

        $this->command->info('✅ 5 sponsorships créés avec succès');
    }
}
