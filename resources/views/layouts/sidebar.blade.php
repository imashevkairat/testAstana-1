<style>

</style>
<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->

        <a class="navbar-brand" href="{{url('/dashboard')}}">

            <img src="{{url('admin/assets/images/brand/logo/logo.svg')}}" alt="logo" />
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">

            @if(auth()->user()->role == 0)
            <li class="nav-item">
                @if(!empty($my_companies))
                    <a class="ml-6 nav-link " type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: unset">
                        @if(count($my_companies) > 1)
                            <strong style="color: white"> {{ auth()->user()->name_companies ?? 'Выберите Компанию' }}</strong>
                        @else
                            <strong style="color: white"> {{ auth()->user()->name_companies ?? 'Выбрать Компанию' }}</strong>
                        @endif
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <form  method="POST" action="{{ route('change.companies') }}">
                            @csrf
                            @foreach($my_companies as $k => $my_companie)
                                <a class="dropdown-item"
                                   onclick="clickChangeCompanies(event,{{ $my_companie['id']}})"
                                >{{$my_companie['name']}}</a>
                            @endforeach
                            <input hidden id="select_companies_id" name="change_companies_id">
                            <button id="change-companies-form" type="submit" hidden></button>
                        </form>
                        <script>
                            function clickChangeCompanies(e,id){
                                e.preventDefault();
                                document.getElementById('select_companies_id').value = id;
                                document.getElementById('change-companies-form').click();
                            }
                        </script>
                    </div>
                @endif
            </li>
            @endif

            <li class="nav-item">
                @if(count($my_companies) > 0 || auth()->user()->role == 1)
                   <a href="{{route('view.applications')}}" class="ml-6 nav-link " >Заявки</a>
                @else
                   <a onclick="alert('Добавьте компанию')" class="ml-6 nav-link " >Заявки</a>
                @endif
            </li>

            <li class="nav-item">
                @if(count($my_companies) > 0 || auth()->user()->role == 1)
                    <a href="{{route('view.vacancies')}}" class="ml-6 nav-link " >Вакансии </a>
                @else
                    <a onclick="alert('Добавьте компанию')" class="ml-6 nav-link " >Вакансии </a>
                @endif
            </li>

            @if(auth()->user()->role == 0)
            <li class="nav-item">
                <a class="ml-6 nav-link " data-toggle="modal" data-target="#exampleModalCenter">Добавить компанию</a>
            </li>

             <li class="nav-item">
                <a class="ml-6 nav-link " data-toggle="modal" data-target="#exampleModalCenterVacancies">Добавить вакансию</a>
            </li>
            @endif
        </ul>
    </div>
</nav>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Добавить компанию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('add.companies')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input required class="form-control" name="bin_companies" placeholder="БИН" type="number" >
                    <input required class="form-control mt-2" name="name_companies" type="text" placeholder="Наименование Компание">
                </div>
                <div class="modal-footer">
                    <button  class="btn btn-secondary" data-dismiss="modal" style="color: white">Закрыть</button>
                    <button  class="btn btn-primary" style="color: white">Добавить</button>
                </div>
            </form>
        </div>
    </div>    
</div>

<div class="modal fade" id="exampleModalCenterVacancies" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Добавить Вакансию</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{route('add.vacancies')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body clickStyleHref">
                        <select name="selected_companies" class="form-control form-control-md block mt-1 w-full" style="border-color: #d1d5db;border-radius: 5px">
                            @foreach($my_companies as $k => $my_companie)
                                <option value="{{ $my_companie['id']}}">{{$my_companie['name']}}</option>
                            @endforeach
                        </select>
                        <input required class="form-control mt-2 mb-2" name="name_vacancies" type="text" placeholder="Наименование Вакансии">

                        <a   id="clickBigInfo" class="mt-2" onclick="clickBigInfo()" data-type="1">Показать Больше</a>

                        <div id="showBigInfo" style="display: none">

                            <textarea class="form-control mt-2 ">Обязанности:</textarea>
                            <textarea class="form-control mt-2 ">Требования:</textarea>
                            <textarea class="form-control mt-2 ">Условия:</textarea>
                            <textarea class="form-control mt-2 ">Ключевые навыки:</textarea>
                            <input placeholder="Зарплата" class="form-control mt-2" type="number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button  class="btn btn-secondary" data-dismiss="modal" style="color: white">Закрыть</button>
                        <button  class="btn btn-primary" style="color: white">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<script type="text/javascript">
    
       function clickBigInfo(){
            var type = $("#clickBigInfo").attr('data-type');

            if (type == 1){
                $("#clickBigInfo").html("Скрыть");
                $("#clickBigInfo").attr('data-type',2);
            }else {
                $("#clickBigInfo").html("Показать Больше");
                $("#clickBigInfo").attr('data-type',1);
            }
            $("#showBigInfo").toggle(' ');

        }

</script>