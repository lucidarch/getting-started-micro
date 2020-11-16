<?php

namespace App\Domains\Link\Jobs;

use Lucid\Units\Job;
use App\Data\Models\Link;

class SaveLinkJob extends Job
{
    private $url;
    private $title;
    private $description;

    /**
     * Create a new job instance.
     *
     * @param $url
     * @param $title
     * @param $description
     */
    public function __construct($url, $title, $description)
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Execute the job.
     *
     * @return Link
     */
    public function handle()
    {
        $attributes = [
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description,
        ];

        return tap(new Link($attributes))->save();
    }
}
