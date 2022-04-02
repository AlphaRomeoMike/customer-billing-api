<?php

namespace App\Console\Commands;

use App\Mail\BillGenerated;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GenerateBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate bills for users';

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
        $users = User::all()->where('role', 'USER');

        foreach ($users as $user) {
            $user->bills()->create([
                'name' => 'Bill for ' . $user->name,
                'amount' => rand(100, 1000),
                'paid' => rand(0, 1),
                'category_id' => Category::all()->random()->id,
                'subcategory_id' => SubCategory::all()->random()->id,
                'user_id' => $user->id,
            ]);

            Mail::to($user->email)->send(new BillGenerated($user, $user->bills->last()));
        }
    }
}
