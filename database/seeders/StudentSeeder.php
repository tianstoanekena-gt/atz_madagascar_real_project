<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Créer le dossier de stockage pour les photos
        Storage::disk('public')->makeDirectory('students');

        $students = [
            [
                'first_name' => 'Faly',
                'last_name' => 'Rakoto',
                'birth_date' => '2015-03-12',
                'gender' => 'M',
                'photo' => 'students/default-student.png', // Photo placeholder
                'location' => 'Antananarivo, Analamanga',
                'whatsapp' => null, // Mineur
                'education_level' => 'primaire',
                'description' => 'Faly est un garçon courageux de 11 ans qui vit avec sa grand-mère. Ses parents ont disparu quand il avait 5 ans. Il rêve de devenir médecin pour soigner les enfants de son quartier.',
                'needs' => 'Fournitures scolaires, frais d\'inscription, uniforme scolaire, chaussures',
                'target_amount' => 450000,
                'collected_amount' => 0,
                'status' => 'active',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'first_name' => 'Voahirana',
                'last_name' => 'Andria',
                'birth_date' => '2012-07-25',
                'gender' => 'F',
                'photo' => 'students/default-student.png',
                'location' => 'Antsirabe, Vakinankaratra',
                'whatsapp' => '+261341234567', // Majeure
                'education_level' => 'college',
                'description' => 'Voahirana a 14 ans et excelle en mathématiques. Elle veut devenir ingénieure pour construire des ponts dans les zones rurales de Madagascar. Elle aide sa mère au marché le weekend.',
                'needs' => 'Livres scolaires, frais de transport, ordinateur portable',
                'target_amount' => 750000,
                'collected_amount' => 250000,
                'status' => 'active',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'first_name' => 'Tiana',
                'last_name' => 'Rabe',
                'birth_date' => '2008-11-03',
                'gender' => 'M',
                'photo' => 'students/default-student.png',
                'location' => 'Toamasina, Atsinanana',
                'whatsapp' => '+261339876543',
                'education_level' => 'lycee',
                'description' => 'Tiana a 18 ans et prépare son baccalauréat. Il est le premier de sa famille à atteindre ce niveau. Passionné d\'informatique, il veut créer des applications pour aider les agriculteurs malgaches.',
                'needs' => 'Frais d\'examen, manuels scolaires, connexion internet',
                'target_amount' => 600000,
                'collected_amount' => 600000,
                'status' => 'completed',
                'is_featured' => false,
                'order' => 3,
            ],
            [
                'first_name' => 'Mialy',
                'last_name' => 'Rasoa',
                'birth_date' => '2005-05-18',
                'gender' => 'F',
                'photo' => 'students/default-student.png',
                'location' => 'Fianarantsoa, Haute Matsiatra',
                'whatsapp' => '+261321122334',
                'education_level' => 'superieur',
                'description' => 'Mialy étudie la médecine à l\'université. Elle veut retourner dans sa région natale pour ouvrir un cabinet médical accessible aux populations rurales. Elle travaille comme serveuse le soir pour financer ses études.',
                'needs' => 'Frais universitaires, matériel médical, logement',
                'target_amount' => 2500000,
                'collected_amount' => 800000,
                'status' => 'active',
                'is_featured' => true,
                'order' => 4,
            ],
            [
                'first_name' => 'Koto',
                'last_name' => 'Ravao',
                'birth_date' => '2010-09-30',
                'gender' => 'M',
                'photo' => 'students/default-student.png',
                'location' => 'Mahajanga, Boeny',
                'whatsapp' => null,
                'education_level' => 'formation_pro',
                'description' => 'Koto a 16 ans et apprend la menuiserie. Il veut créer son propre atelier et former d\'autres jeunes de son quartier. Il est très habile de ses mains et fabrique déjà des meubles simples.',
                'needs' => 'Outils de menuiserie, bois, frais de formation professionnelle',
                'target_amount' => 900000,
                'collected_amount' => 150000,
                'status' => 'active',
                'is_featured' => false,
                'order' => 5,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        $this->command->info('✅ 5 élèves créés avec succès');
    }
}
