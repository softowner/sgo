<?php
namespace App\Tenant;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Company;




Class ManagerTenant
{
    public function setConnection(Company $Company)
    {
        //terminar ligações
        DB::purge('tenant');
       
        //novos dados de configuração
        config()->set('database.connections.tenant.host',     $Company->db_hostname);
        config()->set('database.connections.tenant.database', $Company->db_database);
        config()->set('database.connections.tenant.username', $Company->db_username);
        config()->set('database.connections.tenant.password', $Company->db_password);

       
        DB::reconnect('tenant');
       
         Schema::connection('tenant')->getConnection()->reconnect();
        
       
    }
    

    //verificar se estamos no dominio principal
   /* public function domainIsmain()
    {
       return  request()->getHost() == config('tenant.domain_main');

    }*/

}

