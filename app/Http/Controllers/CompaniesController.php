<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{


    public function addCompanies(Request$request){
        $addCompanies = new Companies();
        $addCompanies['name'] = $request['name_companies'];
        $addCompanies['bin'] = $request['bin_companies'];
        $addCompanies['auth_id'] = auth()->user()->getAuthIdentifier();
        $addCompanies->save();

        return redirect()->back();
    }


    public function changeCompanies(Request $request){
        $getCompanies = Companies::on()->find($request['change_companies_id'])->toArray();
        $editUserSelectedCompanies = User::on()->find(auth()->user()->getAuthIdentifier());
        $editUserSelectedCompanies->id_companies = $getCompanies['id'];
        $editUserSelectedCompanies->name_companies = $getCompanies['name'];
        $editUserSelectedCompanies->save();

        return redirect()->back();

    }
}
