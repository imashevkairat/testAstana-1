<?php

namespace App\Http\Controllers;

use App\Models\Applications;
use App\Models\Companies;
use App\Models\User;
use App\Models\Vacancies;
use App\Models\UserChats;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{

    public $type_with;
    public $viewEditString;

    public function index(){

        if (auth()->user()->role == 0){
            $listVacanies = Vacancies::on()->where('companies_id',auth()->user()->id_companies)->get();
        }else{
            $listVacanies = Vacancies::all();
        }

// dd($listVacanies,'listVacanieslistVacanieslistVacanies');


        // foreach ($listVacanies as $k => $listVacanie){
        //     $kis[$k] = $listVacanie->toArray();
        //     $kis[$k][] = $listVacanie->find($listVacanie->id)->getApplications;

        //     $sss[]=$listVacanie->find($listVacanie->id)->getApplicationss;
        // }

//////
//        dd($kis,$sss);


        return view('vacancies',[
            'listVacanies'=>$listVacanies,
        ]);
    }

    public function addVacancies(Request$request)
    {
        $validated = $request->validate([
            'name_vacancies' => 'required|max:255',
            'selected_companies' => 'required',
        ]);
        $emptyVacancies = Vacancies::on()->where('name',$request['name_vacancies'])
            ->where('companies_id',$request['selected_companies'])
            ->get()->toArray();

        if (!empty($emptyVacancies)){
            $this->type_with = 'success_delete';
            $this->viewEditString = "Данная Вакансия ". $request['name_vacancies'] ." уже добавлено в Компанию ".auth()->user()->name_companies;

            return redirect(route('view.vacancies'))->with($this->type_with,$this->viewEditString);
        }else{
            $this->type_with = 'success';
            $this->viewEditString = 'Успешно Добавлено Вакансия';

            $addVacancies = new  Vacancies();
            $addVacancies['name'] = $request['name_vacancies'];
            $addVacancies['companies_id'] = $request['selected_companies'];
            $addVacancies['auth_id'] = auth()->user()->getAuthIdentifier();
            $addVacancies['type'] = 0;
            $addVacancies->save();
            return redirect(route('view.vacancies'))->with($this->type_with,$this->viewEditString);
        }
    }

    public function getEditVacancies(Request$request){


        if ($request['type'] == 0){
            return response(['success'=>true,'type'=>0,'data'=>Vacancies::on()->find($request['vacancies_id'])]);
        }elseif ($request['type'] == 1){
            $applications = new Applications();
            $applications['companies_id'] = $request['companies_id'];
            $applications['vacancies_id'] = $request['vacancies_id'];
            $applications['user_id'] = auth()->user()->getAuthIdentifier();
            $applications['auth_id'] = $request['auth_id'];
            $applications['type_role'] = 1;
            $applications['type'] = 3;
            $applications->save();
            return response(['success'=>true,'type'=>1]);
        }elseif ($request['type'] == 2){
            Applications::on()->find($request['companies_id'])->delete();
            UserChats::on()->where('application_id',$request['companies_id'])->delete();
            return response(['success'=>true,'type'=>2]);
        }elseif ($request['type'] == 3){


            $arhivVacancies = Vacancies::on()->find($request['vacancies_id']);
            $arhivVacancies['type'] = 0;
            $arhivVacancies->save();

            $textResetVacancies = 'Успешно Востановлен Вакансия '.$arhivVacancies['name'];
            return response(['success'=>$textResetVacancies,'type'=>3]);
//            $this->type_with = 'success_delete';
//            $this->viewEditString = "Успешно Востановлен Вакансия  " . $arhivVacancies->name;


        }





    }

    public function editDeleteVacancies(Request$request){


        if ($request['type_vacancies'] == 0){
            $this->type_with= 'success';
            $editVacancies = Vacancies::on()->find($request['id_vacancies']);
            $this->viewEditString = "Успешно Изменено с ". $editVacancies['name'] . " в ".$request['name_vacancies'];
            $editVacancies['name'] = $request['name_vacancies'];
            $editVacancies->save();
        }elseif ($request['type_vacancies'] == 1){
            $this->type_with = 'success_delete';
            $this->viewEditString = "Успешно Удалено Вакансия  " . $request['name_vacancies'];
            $arhivVacancies = Vacancies::on()->find($request['id_vacancies']);
            $arhivVacancies['type'] = 1;
            $arhivVacancies->save();

            Applications::on()->where('vacancies_id',$request['id_vacancies'])->delete();


//            Vacancies::on()->find($request['id_vacancies'])->delete();
        }
        return redirect(route('view.vacancies'))->with($this->type_with,$this->viewEditString);
    }
}
