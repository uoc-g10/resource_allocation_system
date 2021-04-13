<?php include '../common/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include '../includes/navbar.php'; ?>
        <?php include '../includes/menubar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1> Manage Departments </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href=""><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">
                        Dashboard
                    </li>
                </ol>
            </s     ection>

            <section class="content">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <br>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <a href="#addnew" data-toggle="modal" data-target="#addDepartment" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> New Department</a>
                                            </div>
                                        </div>

                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <div class="row">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                           
                            <!-- Table Content -->

                            <html>
                            <head>
                            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
                            <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
                            <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
                            <style>
                            body
                            {
                            margin:0;
                            padding:0;
                            background-color:#f1f1f1;
                            }
                            .box
                            {
                            width:1100px;
                            padding:20px;
                            background-color:#fff;
                            border:1px solid #ccc;
                            border-radius:5px;
                            margin-top:25px;
                            box-sizing:border-box;
                            }
                            </style>
                            </head>
                            <body>
                            <br />
                            <div class="table-responsive">
                                <br />
                                <div id="alert_message"></div>
                                <table id="user_data" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>Id</th>
                                <th>Department Name</th>
                                <th></th>
                                </tr>
                                </thead>
                                </table>
                            </div>
                            </div>
                            </body>
                            </html>

                            <script type="text/javascript" language="javascript" >
                            $(document).ready(function(){
                            
                            fetch_data();

                            function fetch_data()
                            {
                            var dataTable = $('#user_data').DataTable({
                                "processing" : true,
                                "serverSide" : true,
                                "order" : [],
                                "ajax" : {
                                url:"fetch.php",
                                type:"POST"
                                }
                            });
                            }
                            
                            function update_data(id, column_name, value)
                            {
                            $.ajax({
                                url:"dep_update.php",
                                method:"POST",
                                data:{id:id, column_name:column_name, value:value},
                                success:function(data)
                                {
                                $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
                                $('#user_data').DataTable().destroy();
                                fetch_data();
                                }
                            });
                            setInterval(function(){
                                $('#alert_message').html('');
                            }, 5000);
                            }

                            $(document).on('blur', '.update', function(){
                            var id = $(this).data("id");
                            var column_name = $(this).data("column");
                            var value = $(this).text();
                            update_data(id, column_name, value);
                            });
                            
                            $('#add').click(function(){
                            var html = '<tr>';
                            html += '<td contenteditable id="data1"></td>';
                            html += '<td contenteditable id="data2"></td>';
                            html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
                            html += '</tr>';
                            $('#user_data tbody').prepend(html);
                            });
                       
                                         
                            $(document).on('click', '.delete', function(){
                            var id = $(this).attr("id");
                            if(confirm("Are you sure you want to remove this?"))
                            {
                                $.ajax({
                                url:"dep_delete.php",
                                method:"POST",
                                data:{id:id},
                                success:function(data){
                                $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
                                $('#user_data').DataTable().destroy();
                                fetch_data();
                                }
                                });
                                setInterval(function(){
                                $('#alert_message').html('');
                                }, 5000);
                            }
                            });
                            });
                            </script>

                        </div>
                    </div>
                </div>

            </section>
        </div>

        <!-- Add Department -->
        <div class="modal fade" id="addDepartment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Add new Department</b></h4>
                    </div>
                    <form class="form-horizontal" id="frmbox" method="POST"  enctype="multipart/form-data" onsubmit="return formSubmit();">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Depaerment Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" value="Department Name">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="jquery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript">

        function formSubmit(){
            $.ajax({
                type:'POST',
                url:'department_create.php',
                data:$('#frmbox').serialize(),
                success:function(response){
                    $('#success').html(response);
                }
            });
            var form = document.getElementById('frmbox').reset();
            false;
        }
        </script>

    <?php include '../includes/scripts.php'; ?>
    <?php include '../includes/footer.php'; ?>
    </div>

</body>

</html>