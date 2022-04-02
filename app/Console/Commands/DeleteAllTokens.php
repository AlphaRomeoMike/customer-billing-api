<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteAllTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke and clears all authenticated user tokens';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Revoking all tokens...');

        $users = User::all();

        foreach ($users as $user) {
            $user->token()->revoke();
        }

        $this->info('All tokens revoked!');
    }
}
