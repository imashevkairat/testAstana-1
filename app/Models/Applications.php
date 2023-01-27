<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    use HasFactory;


    public function getCompaniesApplications(){
        return $this->hasOne(Companies::class,'id','companies_id');
    }

    public function getVacaniesApplications(){
        return $this->hasOne(Vacancies::class,  'id','vacancies_id');
    }

    public function getUserApplications(){

        
        if (auth()->user()->role === 0) {
           return $this->hasOne(User::class,  'id','user_id');
        }else{
             return $this->hasOne(User::class,  'id','auth_id');
        }
        
    }

  



}
