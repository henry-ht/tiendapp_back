<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;

class dataFaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:faker {model} {--total=?}';

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
        $options    = $this->option();
        $modelName  = $this->argument('model');
        $totalItems = (int)$options['total'] ? (int)$options['total']:10;

        try {

            switch ($modelName) {
                case 'brand':
                    \App\Models\Brand::factory($totalItems)->create();
                    break;

                case 'product':
                    \App\Models\Product::factory($totalItems)->create();
                    break;

                default:
                    \App\Models\Brand::factory($totalItems)->create();
                    \App\Models\Product::factory($totalItems)->create();
                    break;
            }
            $this->info("data created");
        } catch (\Throwable $th) {
            $this->error('Error msj => '.$th->getMessage().' --//-- Linea => '.$th->getLine().' --//-- file_name => '.$th->getFile());
        }
        // return 0;
    }
}
