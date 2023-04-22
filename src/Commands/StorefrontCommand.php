<?php

namespace Astrogoat\Storefront\Commands;

use Illuminate\Console\Command;

class StorefrontCommand extends Command
{
    public $signature = 'storefront';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
