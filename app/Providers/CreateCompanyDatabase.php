<?php

namespace App\Providers;

use App\Tenant\Database\DatabaseManager;
use App\Providers\CompanyCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCompanyDatabase
{
    private $database;
    /**
     * Create the event listener.
     *
     * @return void
     *
     */

  

    public function __construct(DatabaseManager $database)

    {
        $this->database= $database;
    }

    /**
     * Handle the event.
     *
     * @param  CompanyCreated  $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $company = $event->company();
        if (!$this->database->creatDatabase($company))
        {
            throw new \Exception("Erro criar Base de dados");
        }

        //criar tabelas na base de dados
 
        event(new DataBaseCreated($company));



    }
}
