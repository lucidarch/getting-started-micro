<?php

namespace App\Domains\Link\Tests\Jobs;

use Faker\Factory as Fake;
use Tests\TestCase;
use App\Data\Models\Link;
use App\Domains\Link\Jobs\SaveLinkJob;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaveLinkJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_link_job()
    {
        $f = Fake::create();

        $url = $f->url;
        $title = $f->sentence;
        $description = $f->paragraph;

        $job = new SaveLinkJob($url, $title, $description);
        $link = $job->handle();

        $this->assertInstanceOf(Link::class, $link);
        $this->assertEquals($url, $link->url);
        $this->assertEquals($title, $link->title);
        $this->assertEquals($description, $link->description);
    }
}
