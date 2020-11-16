<?php

namespace App\Features;

use Lucid\Units\Feature;
use App\Domains\Link\Requests\AddLink;
use App\Domains\Link\Jobs\SaveLinkJob;
use App\Domains\Http\Jobs\RedirectBackJob;

class AddLinkFeature extends Feature
{
    public function handle(AddLink $request)
    {
        $this->run(SaveLinkJob::class, [
            'url' => $request->input('url'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return $this->run(new RedirectBackJob());
    }
}
