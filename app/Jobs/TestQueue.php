<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestQueue implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($queueName = 'default')
    {
        $this->onQueue($queueName);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rand = rand(1, 100);
        $data = [
            "name" => "category-" . $rand,
            "description" => 'description-' . $rand,
            "slug" => 'category-' . $rand,
            "active" => rand(0, 1),
            "deleted" => rand(0, 1)
        ];
        Category::create([
            "name" => $data["name"],
            "description" => $data["description"],
            "slug" => $data["slug"],
            "active" => $data["active"],
            "deleted" => $data["deleted"]
        ]);
    }
}
