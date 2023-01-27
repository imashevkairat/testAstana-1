@extends('layouts.app')
@section('content')
    <div class="col-md-10 offset-md-1 mt-2 ">
        <div class="row">

           @if(count($applications) > 0) 
         
           <input class="mb-0" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

            <table id="myTable" class="table ">
                <tr class="header">
                    <th style="width:20%;">Наименование Вакансии</th>
                    <th style="width:20%;">Компание</th>
                    <th style="width:20%;">Email</th>
                    <th style="width:20%;" class="mobile-v">Дата</th>
                </tr>

                @if(!empty($applications))
                 @foreach($applications as $application)
                    <tr data-toggle="modal" data-target="#vacanciesEdit" onclick="showChatUser({{$application->id}})" style="cursor: pointer;">
                        <td id="companie-name-{{ $application->id }}">{{$application->find($application->id)->getVacaniesApplications->name}}</td>
                        <td id="vacanies-name-{{ $application->id }}">{{$application->find($application->id)->getCompaniesApplications->name}}</td>
                        <td id="application-email-{{ $application->id }}">{{$application->find($application->id)->getUserApplications->email}}</td>
                        <td id="get-user-role-{{ $application->id }}" data-get-user-role="{{ $application->find($application->id)->getUserApplications->role }}"  class="mobile-v">{{$application->created_at}}</td>
                    </tr>
                    @endforeach
                @endif
            </table>
            @else
                <h1 class="text-center" style="font-size: 25px;">Нет Отликов</h1>
            @endif
        </div>
    </div>

    <div class="modal fade" id="vacanciesEdit" tabindex="-1" role="dialog" aria-labelledby="vacanciesEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                       <a><strong>Компание :</strong><span id="show-companies">companies</span></a><br>
                       <a><strong>Вакансия :</strong><span id="show-vacancies">vacanies</span></a>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="container">
                    <div class="row clearfix">
                        <div class="col-12 mt-2" >
                            <div class="chat">
                                <div class="chat-header clearfix">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                            </a>
                                            <div class="chat-about">
                                                <h6 class="m-b-0" id="name-user" data-user-role=""></h6>
                                                <strong>Статус</strong>
                                                <small id="status-users" data-status-users="" data-application-id="" ></small>
                                            </div>
                                        </div>
                                        @if(auth()->user()->role == 0)
                                        <div class="col-lg-6 hidden-sm text-right" >
                                            <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-info" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i></a>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                  <!-- <a class="dropdown-item"  onclick="applicationRole(3)" style="cursor: pointer;">Не определен</a> -->
                                                  <a class="dropdown-item"  onclick="applicationRole(2)" style="cursor: pointer;">Пригласить</a>
                                                  <a class="dropdown-item"  onclick="applicationRole(1)" style="cursor: pointer;">Отказать</a>

                                              </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="chat-history" id="chat-history-overflow">
                                    <ul class="m-b-0" id="chat-history-id" data-user="{{ json_encode(auth()->user() ) }}">
                            
                                    </ul>
                                </div>
                                <div class="chat-message clearfix">
                                    <div class="input-group mb-0">
                                  <!--       <div class="input-group-prepend" id="">
                                           <span class="input-group-text"><i class="fa fa-send"></i></span>
                                       </div> -->
                                       <input name="chat_text" id="input-chat" type="text" class="form-control" placeholder="Enter text here...">
                                       <input name="application_id" id="application_id"  hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#input-chat').keyup(function(event) {
                if (event.which === 13){
                    event.preventDefault();
                    let application_id = $('#application_id').val();
                    let input_chat = $('#input-chat').val();
                    var status_user = $("#status-users").attr('data-status-users');

                    if (status_user == 2) {
                         $.ajax({
                          method: 'POST',
                          url: '{{ route('send.user.chat') }}',
                          data:{
                            "_token": "{{ csrf_token() }}",
                            application_id:application_id,
                            input_chat:input_chat,
                          },
                          success:function(response){
                            chats(response);
                          },
                         });
                    }else{
                        user_role = $("#name-user").attr('data-user-role');

                         console.log(user_role,'wsws')   ;

                        if (user_role == 0) {
                            if (status_user == 3) {
                                alert('Статус Не определен ожидаете статус от работодателя')
                            }else if (status_user == 1) {

                                alert('Статус Отказано Работодатель не готов пригласить вас на интервью')
                            }  
                        }else{
                            if (status_user == 3) {
                                alert('Статус Не определен')
                            }else if (status_user == 1) {

                                alert('Статус Отказано')
                            }  
                        }
                    }
                }
            });
        });

        function chats(array_chats){
              var chat = '';
              var chat_r;
              var date_r
              var chat_l;
              var date_l;
              if (array_chats['history_chat'].length > 0) {
                var user = JSON.parse($("#chat-history-id").attr('data-user'));
                $("#chat-history-id").empty();
               for (var i = 0; i < array_chats['history_chat'].length ; i++) {
                chat_r = '';
                date_r = '';
                chat_l = '';
                date_l = '';

                if (array_chats['history_chat'][i]['auth_id'] == user['id']) {
                    chat_r = array_chats['history_chat'][i]['text'];
                    date_r = array_chats['history_chat'][i]['created_at'];
                }else{
                    chat_l = array_chats['history_chat'][i]['text'];
                    date_l = array_chats['history_chat'][i]['created_at'];
                }

 
                if (chat_r.length > 1 && date_r.length > 1) {
                    chat +=
                      "<li class='clearfix'>"+
                           " <div class='message-data text-right'>"+
                                "<span class='message-data-time'>"+
                                   "" + date_r +""+
                                "</span>"+
                            "</div>"+
                            "<div class='message other-message float-right'> "+
                                  "" + chat_r +""+
                            "</div>"+
                        "</li>";
                }else if (chat_l.length > 1 && date_l.length > 1) {
                     chat += 
                      "<li class='clearfix'>"+
                             "<div class='message-data'>"+
                                " <span class='message-data-time'>"+date_l+"</span>"+
                             "</div>"+
                             "<div class='message my-message'>" + chat_l + "</div>"+
                       "</li>";
                }

                  $("#chat-history-id").html(chat);
                  $("#input-chat").val('')    
                  var objDiv = document.getElementById("chat-history-overflow");
                  objDiv.scrollTop = objDiv.scrollHeight;
                } 
            }
        }

        function applicationRole(role){
            var application_id = $("#status-users").attr("data-application-id");
           
              $.ajax({
                method: 'POST', 
                url: '{{ route('application.role') }}', 
                data: {'application_role' : role,'application_id':application_id},
                success: function(response){ 
                editStatus(response)
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });

        }

        function editStatus(response){

              $("#status-users").attr('data-status-users',response['applications']['type']);
              $("#status-users").attr('data-application-id',response['applications']['id']);
              $("#chat-history-id").empty();
              var user_role = $("#name-user").attr('data-user-role');


              if (response['applications']['type']== 3){
                    $("#status-users").html('Не определен');
                    document.getElementById("status-users").className = "application-status-3";
                    $("#chat-history-id").html("<div class='alert alert-danger'  role='alert' > Статус не определен</div");
              }else if(response['applications']['type'] == 2){

                    if (user_role == 1) {
                        $("#status-users").html('Приглашен');
                    }else{
                        $("#status-users").html('Вас Пригласили')
                    }
                    $("#chat-history-id").html("<div class='alert alert-success'  role='alert' > Chat success open </div");
                    document.getElementById("status-users").className = "application-status-2";

              }else if(response['applications']['type'] == 1){

                    if (user_role == 1) {
                        $("#status-users").html('Отказано');
                        $("#chat-history-id").html("<div class='alert alert-danger'  role='alert' > Чтобы начать Чат Пригласите собеседника </div");
                     }else{
                        $("#status-users").html('Вам Отказали');
                        $("#chat-history-id").html("<div class='alert alert-danger'  role='alert' > Работодатель не готов пригласить вас на интервью </div");
                     }

                    document.getElementById("status-users").className = "application-status-1";
              }
        }

        function showChatUser(vacan_id,user){
            $("#show-companies").html(document.querySelector("#companie-name-"+vacan_id).innerHTML)    
            $("#show-vacancies").html(document.querySelector("#vacanies-name-"+vacan_id).innerHTML)
            $("#name-user").html(document.querySelector("#application-email-"+vacan_id).innerHTML)

            $("#name-user").attr('data-user-role',$("#get-user-role-"+vacan_id).attr('data-get-user-role'));
            document.getElementById('application_id').value = vacan_id;

            $.ajax({
                method: 'POST', 
                url: '{{ route('show.user.chat') }}', 
                data: {'vacan_id' : vacan_id},
                success: function(response){ 
                    editStatus(response);
                    chats(response);
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }
    </script>
@endsection

