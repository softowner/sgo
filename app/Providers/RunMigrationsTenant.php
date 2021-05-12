<?php

namespace App\Providers;

use App\Providers\DataBaseCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class RunMigrationsTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DataBaseCreated  $event
     * @return void
     */
    public function handle(DataBaseCreated $event)
    {
        $company= $event->company();
        //criar as tabelas dentro da base de dados de cada company
        Artisan::call('tenants:migrations',[
            'id' =>$company->id,
        ]);
    }
}