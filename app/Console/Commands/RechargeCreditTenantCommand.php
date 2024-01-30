<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

class RechargeCreditTenantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:recharge-credit-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recharges credit for all tenant at the start of each month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->rechargeCreditTenants();
        $this->info('Tenant credit recharged successfully!');
    }

    private function rechargeCreditTenants(): void
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            if ($this->isVerfiedUser($tenant)) {
                $this->rechargeCreditScore($tenant);
            }
        }
    }

    private function isVerfiedUser(Tenant $tenant): bool
    {
        return $tenant->user->email_verified_at != null && $tenant->user->deleted_at == null;
    }

    private function rechargeCreditScore(Tenant $tenant): void
    {
        $creditToAdd = $tenant->is_prime ? 40 : 20;
        $tenant->credit += $creditToAdd;
        $tenant->save();
    }
}
