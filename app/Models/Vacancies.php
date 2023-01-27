<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancies extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'companies_id',
            'auth_id',
            'type',
        ];


    public function getCompanies(){

        return $this->hasOne(Companies::class,'id','companies_id');

    }

    public function getApplications(){

        return $this->hasOne(Applications::class,'vacancies_id','id')->where('user_id',auth()->user()->getAuthIdentifier());
    }

    

}


