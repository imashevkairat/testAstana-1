@extends('layouts.app')
@section('content')
    <div class="blockVacancies">
        <div class="col-10 offset-md-1  showError">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session()->has('success'))
                <div class="alert alert-success" id="success-vacancies" role="alert" style="margin-bottom: 0px">
                    {{session('success')}}
                </div>
            @elseif(session()->has('success_delete'))
                <div class="alert alert-danger" id="success-vacancies" role="alert" style="margin-bottom: 0px">
                    {{session('success_delete')}}
                </div>
            @endif
            <div class="alert alert-success" id="success-vacancies-reset" role="alert" style="display:none;margin-bottom: 0px" ></div>
        </div>
       @if(count($listVacanies) > 0)
        <div class="col-10 offset-md-1  ">
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" style="margin-bottom: 0">
            <table id="myTable" class="table ">
                <tr class="header">
                    <th style="width:20%;">Наименование Вакансии</th>
                    <th style="width:20%;">Компание</th>
                    @if(auth()->user()->role == 0)
                        <th style="width:30%;">
                            Изменить
                        </th>
                    @else
                        <th style="width:30%">
                            Откликнуться
                        </th>
                    @endif
                    <th style="width:20%;" class="mobile-v">Время добавление</th>
                </tr>
                @foreach($listVacanies as $listVacanie)
                    <tr>
                        <td>{{ $listVacanie->name }}</td>
                        <td>{{ $listVacanie->find($listVacanie->id)->getCompanies->name }}</td>
                        <td class="table_td_listVacancies">
                            @if(auth()->user()->role == 0)
                                @if($listVacanie->type == 1)
                                    <a onclick="editVacancies({{$listVacanie->id}},3,{{$listVacanie->find($listVacanie->id)->getCompanies->id}},{{$listVacanie->auth_id}})"   style="cursor:pointer;">Востановить</a>
                                @else
                                    <a onclick="editVacancies({{$listVacanie->id}},0,{{$listVacanie->find($listVacanie->id)->getCompanies->id}},{{$listVacanie->auth_id}})"   data-toggle="modal" data-target="#vacanciesEdit" style="cursor:pointer;">Изменить</a>
                                @endif
                            @else
                              @if($listVacanie->type == 0)
                                @if(isset($listVacanie->find($listVacanie->id)->getApplications))
                                    @if($listVacanie->find($listVacanie->id)->getApplications->companies_id == $listVacanie->companies_id && $listVacanie->find($listVacanie->id)->getApplications->vacancies_id == $listVacanie->id)
                                        <a onclick="editVacancies({{$listVacanie->id}},2,{{$listVacanie->find($listVacanie->id)->getApplications->id}},{{ $listVacanie->auth_id }} )" style="cursor:pointer;font-weight: bold" >Отменить Отлик</a>
                                    @endif
                                @else
                                    <a onclick="editVacancies({{$listVacanie->id}},1,{{$listVacanie->companies_id}},{{$listVacanie->auth_id}})" style="cursor:pointer;" >Откликнуться </a>
                                @endif
                              @else
                                    <a style="cursor:pointer;color: #e98282;font-weight: bold;" > Удален</a>
                              @endif  

                            @endif
                        </td>
                        <td class="mobile-v">{{ $listVacanie->created_at }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        @else
            <h1 class="text-center" style="font-size: 25px;">Нет Добавленных Вакансии в компание  {{ auth()->user()->name_companies ?? 'Выберите Компанию' }}<br>
                  <a class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenterVacancies" style="color: white;">
                       Добавить Вакансии
                 </a>
             </h1>
        @endif
       
    </div>


    <div class="modal fade" id="vacanciesEdit" tabindex="-1" role="dialog" aria-labelledby="vacanciesEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">vacanciesEdit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{route('edit.vacancies')}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="modal-body clickStyleHref">
                        <input disabled value="{{auth()->user()->name_companies}}"  class="form-control">
                        <input hidden name="id_vacancies" id="id_vacancies">
                        <input hidden name="type_vacancies" id="type_vacancies">
                        <input class="form-control mt-2 mb-2" id="edit_name_vacancies" name="name_vacancies" type="text" placeholder="Наименование Вакансии">
                    </div>
                    <div class="modal-footer">
                        <button  class="btn btn-secondary" data-dismiss="modal" style="color: white">Закрыть</button>
                        <button  class="btn btn-danger" data-dismiss="modal" style="color: white" onclick="deleteVacanies()">Удалить</button>
                        <button  class="btn btn-primary" style="color: white" id="edit_delete_form" >Сохранить Изменение</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function deleteVacanies(){
            if (confirm('Вы уверены что хотите удалить')){
                document.getElementById('type_vacancies').value = 1;
                document.getElementById('edit_delete_form').click();
            }
        }

        function editVacancies(vacancies_id,type,companies_id,auth_id){
            var type_confirm = false;

            if(type === 2 && confirm('Вы уверены что хотите Отменить Отлик')){
                type_confirm = true;
            }else if(type === 0 || type === 1 || type === 3){
                type_confirm = true;
            }
            

            if (type_confirm){
                $.ajax({
                    url: "/get/edit/vacancies",
                    type:'POST',
                    method: 'POST',
                    data: {_token:_token,vacancies_id:vacancies_id,companies_id:companies_id,type:type,auth_id:auth_id},
                    success: function(data) {
                        if (data['type'] === 0){
                            document.getElementById('edit_name_vacancies').value = data['data']['name']
                            document.getElementById('id_vacancies').value = vacancies_id
                            document.getElementById('type_vacancies').value = '0';
                        }else if(data['type'] === 1 || data['type'] === 2){
                            location.reload();
                        }else if (data['type'] === 3){
                            // location.reload();
                            $("#myTable").load("/index/vacancies #myTable");
                            $("#success-vacancies-reset").html(data['success']);
                            document.getElementById("success-vacancies-reset").style.display = 'block'
                            setTimeout(function () {
                                document.getElementById('success-vacancies-reset').style.display = 'none';
                            }, 4000)
                        }
                    }
                });
            }
        }
        setTimeout(function () {
            document.getElementById('success-vacancies').style.display = 'none';
        }, 4000)
    </script>
@endsection

