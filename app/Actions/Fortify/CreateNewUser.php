<?php

namespace App\Actions\Fortify;

use App\Http\Controllers\Tenant\CompanyController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
/*importar model companies */
use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $company= $this->getCompany($input['email']);
       
        //dd( $company);
       // $input['vat']='123456789';
        if(!$company)
        {
            
            //regista company
            app(CompanyController::class)->store([
                'companyname' => $input['name'],
                'email' => $input['email'],
                'vat' => $input['nif'],
                ]);
         
            
                
            ///////////////$company= $this->getCompany($input['email']);
            

            
            
            //muda ligação da  DB
            //app(ManagerTenant::class)->setConnection($company);

            
            
            // Regista o user
            Validator::make($input, [
                'nif' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            ])->validate();

            return User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);


        }
        else
        {
            //pode redireçionar login  com aviso que empresa já está registada
           //return redirect()->route('/');
            dd('ja existe');      
            //Redirect::route('/');
            //return redirect('/login');
        }
    }

    public function getCompany($email)
    {
        return Company::where('email',$email)->first();

    }
}
