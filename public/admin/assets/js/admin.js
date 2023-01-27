// ////vacanies 
//     function deleteVacanies(){
//             if (confirm('Вы уверены что хотите удалить')){
//                 document.getElementById('type_vacancies').value = 1;
//                 document.getElementById('edit_delete_form').click();
//             }
//         }

//     function editVacancies(vacancies_id,type,companies_id,auth_id){
//             $.ajaxSetup({
//                 headers: {
//                     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
//                 }
//             });
//             var _token = $("input[name='_token']").val();
//             var type_confirm = false;

//             if(type === 2 && confirm('Вы уверены что хотите Отменить Отлик')){
//                 type_confirm = true;
//             }else if(type === 0 || type === 1 || type === 3){
//                 type_confirm = true;
//             }




//             if (type_confirm){
//                 $.ajax({
//                     url: "/get/edit/vacancies",
//                     type:'POST',
//                     method: 'POST',
//                     data: {_token:_token,vacancies_id:vacancies_id,companies_id:companies_id,type:type,auth_id:auth_id},
//                     success: function(data) {
//                         if (data['type'] === 0){
//                             document.getElementById('edit_name_vacancies').value = data['data']['name']
//                             document.getElementById('id_vacancies').value = vacancies_id
//                             document.getElementById('type_vacancies').value = '0';
//                         }else if(data['type'] === 1 || data['type'] === 2){

//                             location.reload();

//                         }else if (data['type'] === 3){
//                             // location.reload();
//                             $("#myTable").load("/index/vacancies #myTable");
//                             $("#success-vacancies-reset").html(data['success']);
//                             document.getElementById("success-vacancies-reset").style.display = 'block'
//                             document.getElementById("success-reset-margin").style.marginBottom = '0px'
//                             setTimeout(function () {
//                                 document.getElementById('success-vacancies-reset').style.display = 'none';
//                             }, 4000)
//                         }
//                     }
//                 });
//             }
//         }

// ////application
//     $(document).ready(function() {
//             $('#input-chat').keyup(function(event) {
//                 if (event.which === 13){
//                     event.preventDefault();
//                     let application_id = $('#application_id').val();
//                     let input_chat = $('#input-chat').val();
//                     var status_user = $("#status-users").attr('data-status-users');

//                     if (status_user == 2) {
//                          $.ajax({
//                           method: 'POST',
//                           url: '{{ route('send.user.chat') }}',
//                           data:{
//                             "_token": "{{ csrf_token() }}",
//                             application_id:application_id,
//                             input_chat:input_chat,
//                           },
//                           success:function(response){
//                             chats(response);
//                           },
//                          });
//                     }else{
//                         user_role = $("#name-users").attr('data-user-role');

//                          console.log(user_role,'wsws')   ;

//                         if (user_role == 0) {
//                             if (status_user == 3) {
//                                 alert('Статус Не определен ожидаете статус от работодателя')
//                             }else if (status_user == 1) {

//                                 alert('Статус Отказано Работодатель не готов пригласить вас на интервью')
//                             }  
//                         }else{
//                             if (status_user == 3) {
//                                 alert('Статус Не определен')
//                             }else if (status_user == 1) {

//                                 alert('Статус Отказано')
//                             }  
//                         }
//                     }
//                 }
//             });
//         });

//     function chats(array_chats){
//               var chat = '';
//               var chat_r;
//               var date_r
//               var chat_l;
//               var date_l;
//               if (array_chats['history_chat'].length > 0) {
//                 var user = JSON.parse($("#chat-history-id").attr('data-user'));
//                 $("#chat-history-id").empty();
//                for (var i = 0; i < array_chats['history_chat'].length ; i++) {
//                 chat_r = '';
//                 date_r = '';
//                 chat_l = '';
//                 date_l = '';

//                 if (array_chats['history_chat'][i]['auth_id'] == user['id']) {
//                     chat_r = array_chats['history_chat'][i]['text'];
//                     date_r = array_chats['history_chat'][i]['created_at'];
//                 }else{
//                     chat_l = array_chats['history_chat'][i]['text'];
//                     date_l = array_chats['history_chat'][i]['created_at'];
//                 }

 
//                 if (chat_r.length > 1 && date_r.length > 1) {
//                     chat +=
//                       "<li class='clearfix'>"+
//                            " <div class='message-data text-right'>"+
//                                 "<span class='message-data-time'>"+
//                                    "" + date_r +""+
//                                 "</span>"+
//                             "</div>"+
//                             "<div class='message other-message float-right'> "+
//                                   "" + chat_r +""+
//                             "</div>"+
//                         "</li>";
//                 }else if (chat_l.length > 1 && date_l.length > 1) {
//                      chat += 
//                       "<li class='clearfix'>"+
//                              "<div class='message-data'>"+
//                                 " <span class='message-data-time'>"+date_l+"</span>"+
//                              "</div>"+
//                              "<div class='message my-message'>" + chat_l + "</div>"+
//                        "</li>";
//                 }

//                   $("#chat-history-id").html(chat);
//                   $("#input-chat").val('')    
//                   var objDiv = document.getElementById("chat-history-overflow");
//                   objDiv.scrollTop = objDiv.scrollHeight;
//                 } 
//             }
//         }

//     function applicationRole(role){
//             var application_id = $("#status-users").attr("data-application-id");
//             var user_role = [];
//             user_role['role'] = $("#name-users").attr('data-user-role');

//               $.ajax({
//                 method: 'POST', 
//                 url: '{{ route('application.role') }}', 
//                 data: {'application_role' : role,'application_id':application_id},
//                 success: function(response){ 


//                 editStatus(response,user_role)
//                 },
//                 error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
//                     console.log(JSON.stringify(jqXHR));
//                     console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
//                 }
//             });

//         }

//     function editStatus(response,user){
    

//               console.log(response['applications']['type'],'wwws');


//               $("#status-users").attr('data-status-users',response['applications']['type']);
//               $("#status-users").attr('data-application-id',response['applications']['id']);

//               if (response['applications']['type']== 3){
//                     document.getElementById("status-users").className = "application-status-3";
//                     $("#status-users").html('Не определен');
//               }else if(response['applications']['type'] == 2){
//                     if (user['role'] == 1) {
//                         $("#status-users").html('Приглашен');
//                     }else{
//                         $("#status-users").html('Вас Пригласили')
//                     }
//                     $("#chat-history-id").html("<div class='alert alert-success'  role='alert' > Chat success open </div");
//                     document.getElementById("status-users").className = "application-status-2";
//               }else if(response['applications']['type'] == 1){

//                        if (user['role'] == 1) {
//                            $("#status-users").html('Отказано');
//                            $("#chat-history-id").html("<div class='alert alert-danger'  role='alert' > Чтобы начать Чат Пригласите собеседника </div");
//                         }else{
//                            $("#status-users").html('Вам Отказали');
//                            $("#chat-history-id").html("<div class='alert alert-danger'  role='alert' > Работодатель не готов пригласить вас на интервью </div");
//                         }

//                     document.getElementById("status-users").className = "application-status-1";
//               }
//         }

//     function showChatUser(vacan_id,user){
           
//             document.getElementById('application_id').value = vacan_id;
//             $("#name-users").html(user['email']);
//             $("#name-users").attr('data-user-role',user['role']);

           


//             $.ajax({
//                 method: 'POST', 
//                 url: '{{ route('show.user.chat') }}', 
//                 data: {'vacan_id' : vacan_id},
//                 success: function(response){ 
//                     editStatus(response,user);
//                     chats(response);
//                 },
//                 error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
//                     console.log(JSON.stringify(jqXHR));
//                     console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
//                 }
//             });




//         }
// ///// side bar
//     function clickBigInfo(){
//             var type = $("#clickBigInfo").attr('data-type');

//             if (type == 1){
//                 $("#clickBigInfo").html("Скрыть");
//                 $("#clickBigInfo").attr('data-type',2);
//             }else {
//                 $("#clickBigInfo").html("Показать Больше");
//                 $("#clickBigInfo").attr('data-type',1);
//             }
//             $("#showBigInfo").toggle(' ');

//         }     
// //// all view ** script 
   $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
   var _token = $("input[name='_token']").val();
   function myFunction() {
   var input, filter, table, tr, td, i, txtValue;
   input = document.getElementById("myInput");
   filter = input.value.toUpperCase();
   table = document.getElementById("myTable");
   tr = table.getElementsByTagName("tr");
   for (i = 0; i < tr.length; i++) {
       td = tr[i].getElementsByTagName("td")[0];
       if (td) {
           txtValue = td.textContent || td.innerText;
           if (txtValue.toUpperCase().indexOf(filter) > -1) {
               tr[i].style.display = "";
           } else {
               tr[i].style.display = "none";
           }
       }
    }
}

