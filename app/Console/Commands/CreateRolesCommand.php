<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateRolesCommand extends Command
{
    protected $signature = 'roles:create';
    protected $description = 'Créer les rôles de base pour ATZ Madagascar';

    public function handle()
    {
        $roles = ['admin', 'parrain', 'sponsor', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
            $this->info("Rôle '{$role}' créé ou déjà existant.");
        }

        $this->info('✅ Tous les rôles de base sont prêts !');
    }
}
