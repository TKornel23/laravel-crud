@extends('layouts.app')

@section('content')
<div class="container">
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="searchBar" placeholder="Search for Student" aria-label="" aria-describedby="basic-addon1">
        <div class="input-group-prepend">
          <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Add new Student</button>
        </div>        
      </div>
    <table class="table table-striped table-bordered">
        <thead>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Day of Birth</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>           
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Student Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="mb-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="name" class="form-control" id="name" aria-describedby="name">
                  </div>
                  <div class="mb-2">
                  <label for="address" class="form-label">Address</label>
                  <input type="address" class="form-control" id="address" aria-describedby="address">
                </div>
                <div class="mb-2">
                  <label for="exampleInputEmail1" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-2">
                  <label for="phoneNumber" class="form-label">Phone Number</label>
                  <input type="phoneNumber" class="form-control" id="phoneNumber" aria-describedby="phone">
                </div>
                  <div class="mb-2">
                    <label for="birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="birth" aria-describedby="birth">
                  </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="add-student" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Edit Student Modal -->
  <div class="modal fade" id="edit-student-modal" tabindex="-1" aria-labelledby="edit-student-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="edit-student-modal">Edit Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
              <input type="hidden" id="student-id">
                <div class="mb-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="name" class="form-control" id="edit-name" aria-describedby="name">
                  </div>
                  <div class="mb-2">
                  <label for="address" class="form-label">Address</label>
                  <input type="address" class="form-control" id="edit-address" aria-describedby="address">
                </div>
                <div class="mb-2">
                  <label for="exampleInputEmail1" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="edit-email" aria-describedby="emailHelp">
                </div>
                <div class="mb-2">
                  <label for="phoneNumber" class="form-label">Phone Number</label>
                  <input type="phoneNumber" class="form-control" id="edit-phoneNumber" aria-describedby="phone">
                </div>
                  <div class="mb-2">
                    <label for="birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="edit-birth" aria-describedby="birth">
                  </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="update-student" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<script>
    $(document).ready(function(){
              
      $(document).on('click','#update-student', function(e){
        e.preventDefault();
        var studentId = $('#student-id').val();
        var data = {
          'name':$('#edit-name').val(),
          'email':$('#edit-email').val(),
          'address':$('#edit-address').val(),
          'phoneNumber':$('#edit-phoneNumber').val(),
          'birthday':$('#edit-birth').val()
        }
        $.ajax({
          type: "PUT",
          url: "/update-student/"+ studentId,
          data: data,
          dataType: "json",
          success: function (response) {
            console.log(response);
            $('#edit-student-modal').modal('hide');
          }
        });
        fetch();
      });




      $('#searchBar').on('keyup',function(){
        var value = $(this).val().toLowerCase();
        $("tbody tr").filter(function(){
          $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);
        });
      });

      fetch();
        $(document).on('click','#add-student', function(e){
            e.preventDefault();
            var student = {             
                'name':$('#name').val(),
                'email':$('#email').val(),
                'address':$('#address').val(),
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

        $(document).on('click','#edit-student',function(e){
          e.preventDefault();
          var studentId = $(this).val();
          //console.log(studentId);
          $('#edit-student-modal').modal('show');
          $.ajax({
            type: "GET",
            url: "/edit-student/"+ studentId,
            dataType: "json",
            success: function (response) {
              if(response.student == 404){

              }
              else{
                $('#edit-name').val(response.student.name);
                $('#edit-address').val(response.student.address);
                $('#edit-phoneNumber').val(response.student.phoneNumber);
                $('#edit-email').val(response.student.email);
                $('#edit-birth').val(response.student.birthday);
                $('#student-id').val(response.student.id);
              }
            }
          });
        })

        function fetch(){
          $.ajax({
                type:"GET",
                url:"/fetch-students",
                datyType:"json",
                success: function(response){
                  $('tbody tr').html("");
                  $.each(response.students, function(key, item){
                    $('tbody').append('\
                      <tr>\
                        <td>'+ item.name +'</td>\
                        <td>'+ item.address +'</td>\
                        <td>'+ item.email +'</td>\
                        <td>' + item.phoneNumber+'</td>\
                        <td>' + item.birthday+'</td>\
                        <td style="text-align:center;">\
                          <button type="button" value="'+ item.id+'" id="edit-student" class="btn btn-success">Edit</button></td>\
                        <td style="text-align:center;"> <button type="button" value="'+ item.id+'" id="delete-student" class="btn btn-danger">Delete</button>\
                        </td>\
                      </tr>\
                    ');
                  })
                }
            });
        }
    });
</script>
@endsection