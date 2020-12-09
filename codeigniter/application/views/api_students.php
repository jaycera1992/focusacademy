<html>
<head>
    <title>Focus Academy</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    
    <div class="container">
        <br />
        <h2 align="center">Manage - Students</h2>
        <p>
        <a class="btn btn-primary" href="http://localhost/focusacademy/codeigniter/test_api" role="button">
            Classes
        </a>
        <a class="btn btn-danger active" href="http://localhost/focusacademy/codeigniter/students_api" role="button">
            Students
        </a>
        </p>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">Student - Lists</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Class Name</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<div id="studentModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="student_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Students</h4>
                </div>
                <div class="modal-body">
                    <span id="max_students_error" class="text-danger"></span><br/>
                    <label>Enter First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" />
                    <span id="first_name_error" class="text-danger"></span>
                    <br />
                    <label>Enter Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" />
                    <span id="last_name_error" class="text-danger"></span>
                    <br />
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" />
                    <span id="date_of_birth_error" class="text-danger"></span>
                    <br />
                    <label>Class</label>
                    <select class="form-control" name="class" id="class">
                        <option>Default select</option>
                    </select>
                    <span id="class_error" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="student_id" id="student_id" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    
    function fetch_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>students_api/action",
            method:"POST",
            data:{data_action:'fetch_all'},
            success:function(data)
            {
                $('tbody').html(data);
            }
        });
    }

    function fetch_data_class()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>students_api/action",
            method:"POST",
            data:{data_action:'fetch_all_class'},
            success:function(data)
            {
                $('#class').html(data);
            }
        });
    }

    fetch_data();
    fetch_data_class();

    $('#add_button').click(function(){
        $('#student_form')[0].reset();
        $('.modal-title').text("Add Class");
        $('#action').val('Add');
        $('#data_action').val("Insert");
        $('#studentModal').modal('show');
    });

    $(document).on('submit', '#student_form', function(event){
        event.preventDefault();
        var className = $('#class option:selected').html();
        $.ajax({
            url:"<?php echo base_url() . 'students_api/action' ?>",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                if(data.success)
                {
                    $('#student_form')[0].reset();
                    $('#studentModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success_message').html('<div class="alert alert-success">Successfully Created Student</div>');
                    }
                    else if($('#data_action').val() == "Edit")
                    {
                        $('#success_message').html('<div class="alert alert-success">Successfully Edited!</div>');
                    }
                }

                if(data.error)
                {
                    if(data.max_students){
                        $('#max_students_error').html(data.message + className + '! Max students reached!');
                    }
                    $('#class_error').html(data.student_class_error);
                    $('#first_name_error').html(data.student_first_name_error);
                    $('#last_name_error').html(data.student_last_name_error);
                    $('#date_of_birth_error').html(data.student_date_of_birth);
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var student_id = $(this).attr('id');
        $.ajax({
            url:"<?php echo base_url(); ?>students_api/action",
            method:"POST",
            data:{student_id:student_id, data_action:'fetch_single'},
            dataType:"json",
            success:function(data)
            {
                console.log(data.date_of_birth);
                $('#studentModal').modal('show');
                $('#class').val(data.class_id);
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#date_of_birth').val(data.date_of_birth);
                $('.modal-title').text('Edit Student');
                $('#student_id').val(student_id);
                $('#action').val('Edit');
                $('#data_action').val('Edit');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var student_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url:"<?php echo base_url(); ?>students_api/action",
                method:"POST",
                data:{student_id:student_id, data_action:'Delete'},
                dataType:"JSON",
                success:function(data)
                {
                    if(data.success)
                    {
                        $('#success_message').html('<div class="alert alert-success">Class Deleted</div>');
                        fetch_data();
                    }
                }
            })
        }
    });
    
});
</script>