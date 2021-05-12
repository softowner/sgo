<?php 
namespace App\Tenant\Database;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{

private $company;


    public function creatDatabase(Company $company)
    {
       
      return  DB::statement("CREATE DATABASE $company->db_database CHARACTER SET = 'utf8mb4' COLLATE = 'utf8mb4_unicode_ci'") ;


    }

}