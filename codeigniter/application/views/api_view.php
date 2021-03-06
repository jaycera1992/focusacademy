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
        <h2 align="center">Manage - Classes</h2>
        <p>
        <a class="btn btn-danger active" href="http://localhost/focusacademy/codeigniter/test_api" role="button">
            Classes
        </a>
        <a class="btn btn-primary" href="http://localhost/focusacademy/codeigniter/students_api" role="button">
            Students
        </a>
        </p>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">Classes - Lists</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <span id="error_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Class Code</th>
                            <th>Name</th>
                            <th>Max Students</th>
                            <th>Description</th>
                            <th>Status</th>
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

<div id="classModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="class_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Class</h4>
                </div>
                <div class="modal-body">
                    <label>Enter Class Code</label>
                    <input type="text" name="class_code" id="class_code" class="form-control" />
                    <span id="class_code_error" class="text-danger"></span>
                    <br />
                    <label>Enter Class Name</label>
                    <input type="text" name="class_name" id="class_name" class="form-control" />
                    <span id="class_name_error" class="text-danger"></span>
                    <br />
                    <label>No. of Students</label>
                    <input type="number" name="no_of_students" id="no_of_students" class="form-control" />
                    <span id="no_of_students_error" class="text-danger"></span>
                    <br />
                    <label>Description</label>
                    <input type="text" name="class_description" id="class_description" class="form-control" />
                    <span id="description_error" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="class_id" id="class_id" />
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
            url:"<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data:{data_action:'fetch_all'},
            success:function(data)
            {
                $('tbody').html(data);
            }
        });
    }

    fetch_data();

    $('#add_button').click(function(){
        $('#class_form')[0].reset();
        $('.modal-title').text("Add Class");
        $('#action').val('Add');
        $('#data_action').val("Insert");
        $('#classModal').modal('show');
    });

    $(document).on('submit', '#class_form', function(event){
        event.preventDefault();
        $.ajax({
            url:"<?php echo base_url() . 'test_api/action' ?>",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                if(data.success)
                {
                    $('#class_form')[0].reset();
                    $('#classModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success_message').html('<div class="alert alert-success">Class Inserted</div>');
                    }
                    else if($('#data_action').val() == "Edit")
                    {
                        $('#success_message').html('<div class="alert alert-success">Successfully Edited!</div>');
                    }
                }

                if(data.error)
                {
                    $('#class_code_error').html(data.class_code_error);
                    $('#class_name_error').html(data.class_name_error);
                    $('#description_error').html(data.class_description_error);
                    $('#no_of_students_error').html(data.no_of_students_error);
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var class_id = $(this).attr('id');
        $.ajax({
            url:"<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data:{class_id:class_id, data_action:'fetch_single'},
            dataType:"json",
            success:function(data)
            {
                $('#classModal').modal('show');
                $('#class_code').val(data.class_code);
                $('#class_name').val(data.class_name);
                $('#class_description').val(data.class_description);
                $('#no_of_students').val(data.no_of_students);
                $('.modal-title').text('Edit Class');
                $('#class_id').val(class_id);
                $('#action').val('Edit');
                $('#data_action').val('Edit');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var class_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url:"<?php echo base_url(); ?>test_api/action",
                method:"POST",
                data:{class_id:class_id, data_action:'Delete'},
                dataType:"JSON",
                success:function(data)
                {
                    if(data.success)
                    {   
                        $('#success_message').html('<div class="alert alert-success">Class Deleted</div>');
                        fetch_data();
                    } else {
                        if(data.existing_student) {
                            $('#error_message').html('<div class="alert alert-danger">' + data.message + '</div>');
                        }
                    }
                }
            })
        }
    });
    
});
</script>