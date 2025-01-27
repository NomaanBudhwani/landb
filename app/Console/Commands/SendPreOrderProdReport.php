<?php

namespace App\Console\Commands;

use App\Mail\PreOrderProdQty;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPreOrderProdReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:preorder-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Pre Order Product Report';

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
        Mail::to([
            'amir@landbapparel.com',
            'erika.ibarra@luckyfactory.com.mx',
            'heron.femat@landbapparel.com',
            'luis.garza@luckyfactory.com.mx',
            'jesus.arredondo@luckyfactory.com.mx',
            'magdalena@landbapparel.com',
            'bintou@landbapparel.com',
            'ramsha@landbapparel.com',
            'edgarb@landbapparel.com',
            'luis.parra@luckyfactory.com.mx',
            'alejandro.ruiz@luckyfactory.com.mx',
            'monica.rodriguez@luckyfactory.com.mx',
            'hilda.dealba@luckyfactory.com.mx',
            'abiam.vasquez@luckyfactory.com.mx',
            'hassan@landbapparel.com',
            ])->send(new PreOrderProdQty());

        echo 'success';
    }
}
