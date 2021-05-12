<?php

namespace App\Http\Controllers\Tenant;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Providers\CompanyCreated;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
    private $company;

    public function  __construct(Company $company )
    {
       $this->company = $company;
    }

  /*  public function  index()
    {
       return Company::all();
    }
*/
  /*  public function  store(Request $request)
    {
        #registar empresa
        #encriptar password
        $userpassword='12345678';
        $userpassword= bcrypt($userpassword);

        $company= $this->company->create([
            'vat'           =>'vat x' . Str::random(5),
            'companyname'   =>'Empresa x' . Str::random(5),
            'email'         =>'teste@email.com',
            'password'      =>$userpassword,
            'db_database'   =>'db_20979559',
            'db_hostname'   =>'127.0.0.1',
            'db_username'   =>'root',
            'db_password'   =>'',
            

        ]);

    }*/
    public function  store($array)
    {

        $companyname=$array['companyname'];
        $vat=$array['vat'];
        $email=$array['email'];
        //dd($email);
        #registar empresa
        #encriptar password
        $userpassword='12345678';
        $userpassword= bcrypt($userpassword);

        $company= $this->company->create([
            'vat'           =>$vat,
            'companyname'   =>$companyname,
            'email'         =>$email,
            'password'      =>$userpassword,
            'db_database'   =>'db_'.$vat,
            'db_hostname'   =>'127.0.0.1',
            'db_username'   =>'root',
            'db_password'   =>'',
            

        ]);
            event(new CompanyCreated($company));

    }
}
