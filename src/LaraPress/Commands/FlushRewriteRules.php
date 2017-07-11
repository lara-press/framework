<?php

namespace LaraPress\Commands;

use Illuminate\Console\Command;

class FlushRewriteRules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush WordPress Rewrite Rules';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        flush_rewrite_rules();

        $this->info('Flushed!');
    }
}
