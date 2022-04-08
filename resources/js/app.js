

$(document).ready(function(){
              
    fetch();
      $(document).on('click','#add-student', function(e){
          e.preventDefault();
          var student = {
              'name':$('#name').val(),
              'email':$('#email').val(),
              'phoneNumber':$('#phoneNumber').val(),
              'birthday':$('#birth').val()
          }
          
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
              type:"POST",
              url:"/student",
              data:student,
              datyType:"json"
          });        
          fetch();   
      });

      function fetch(){
        $.ajax({
              type:"GET",
              url:"/fetch-students",
              datyType:"json",
              success: function(response){
                console.log(response.students);
                $('tbody').html("");
                $.each(response.students, function(key, item){
                  $('tbody').append('\
                    <tr>\
                      <td>'+ item.name +'</td>\
                      <td>'+ item.email +'</td>\
                      <td>' + item.phoneNumber+'</td>\
                      <td>' + item.birthday+'</td>\
                    </tr>\
                  ');
                })
              }
          });
      }
  });