<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //nome do comando é opção enviar o id da empresa e fazer o refresh
   // protected $signature = 'tenants:migrations {id?} {--refresh}';
   protected $signature = 'tenants:migrations {id?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run tenants Migrate';
    private $Tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $Tenant)
    {
        parent::__construct();
        $this->Tenant = $Tenant;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       

        if($idcompany= $this->argument('id'))
        {
            $company = Company::find($idcompany);
            $this->execCommand($company);
            return;

        }

        $companies = Company::all();
        foreach($companies  as $company){
           $this->execCommand($company);
        }
    }

    public function execCommand(Company $company)
    {
        //$command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';
        $command = 'migrate';
        
        $this->Tenant->setConnection($company);
        
        //$this->info("Ligado a {$company->companyname}");

        Artisan::call($command,[
            '--force' => true,
            '--path' => '/database/migrations/tenant',
        ]);   
      
       // $this->info("Desligado de {$company->companyname}");
        //$this->info("---------------------");
        return ;

    }


}

