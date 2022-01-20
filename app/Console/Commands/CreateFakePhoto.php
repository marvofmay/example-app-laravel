<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Photo;

class CreateFakePhoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:create {qty?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $qty = $this->argument('qty') ? $this->argument('qty') : 1;
        Photo::factory()->count($qty)->create();
        $this->info('The command was successful!');
    }
}
