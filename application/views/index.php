<html>
    <head>
        <meta charset="UTF-8">
        <link href="/cw/assets/css/bootstrap.css" rel="stylesheet">
        <script src="/cw/js/jquery-2.1.4.js"></script>
        <script src="/cw/assets/js/bootstrap.js"></script>
        <script src="/cw/js/bootbox.min.js"></script>
        <title>Harry Potter Quiz</title>
        <script type="text/javascript">
            window.history.forward();
            function noBack() {
                window.history.forward();
            }
        </script>
    </head>
    <body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="" oncontextmenu="return false;">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-5">
                        <h1>Welcome to the Harry Potter Quiz</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="pull-right">
                        <button type="button" id="btnAdmin" class="btn btn-primary btn-md" name="admin_button"  data-target="#adminlogin"><span class="glyphicon glyphicon-user" aria-hidden="true"> Admin</span></button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <h3>Are you a die hard fan of Harry Potter? Do you wish to test your skills? Find out with this quiz! It covers the contents of all seven books and eight movies. <b>Good Luck!</b></h3>
                        <br><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-7">
                        <div class="col-xs-5">
                            <label for="txtName">Enter Nickname:</label>
                            <input type="text" name="txtName" class="form-control" size="20" id="txtName"/>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-2">
                        <form action="/cw/index.php/Index_Controller/quiz" method="POST">
                            <input class="btn btn-success btn-lg" id="btnStart" type="button" name="start" value="Begin Quiz">
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="adminlogin" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Admin Login</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmadmin" name="frmadmin" action="/cw/index.php/index_controller/redirect">
                            <div class="form-group row">
                                <label for="txtUsername" class="col-sm-2 form-control-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtUsername" name="txtUsername" class="form-control" placeholder="Username"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtPassword" class="col-sm-2 form-control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" id="btnLogin" class="btn btn-secondary">Sign in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>    
    </body>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#btnStart').unbind('click').bind('click', function () {
                $player = $('#txtName').val();//get username
                if ($('#txtName').val() == '')
                {//if no name give default name
                    $player = 'Guest';
                }
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/index_controller/setSession'; ?>',
                    type: 'POST',
                    data: {'player': $player},
                    success: function (res) {
                        bootbox.alert({
                            title: '<b><font color="blue">Success</font></b>',
                            message: '<h4>Good Luck ' + $player + '</h4>',
                            callback: function () {
                                window.location.href = '<?php echo base_url() . 'index.php/index_controller/quiz'; ?>';
                            }
                        });

                    }
                });
            });
            //show admin modal
            $('#btnAdmin').unbind('click').bind('click', function () {
                $('#adminlogin').modal();
                $('#adminlogin').show();
            });
            //sign in function
            $('#adminlogin').find('#btnLogin').unbind('click').bind('click', function () {
                $username = $('#frmadmin').find('#txtUsername').val();
                $password = $('#frmadmin').find('#txtPassword').val();
                //validation
                if ($('#frmadmin').find('#txtUsername').val() == '')
                {
                    bootbox.alert({
                        title: '<b><font color="red">Error</font></b>',
                        message: 'Please enter a username'
                    });
                }
                else if ($('#frmadmin').find('#txtPassword').val() == '')
                {
                    bootbox.alert({
                        title: '<b><font color="red">Error</font></b>',
                        message: 'Please enter a password'
                    });
                }
                else
                {
                    $.ajax({ 
                        url: '<?php echo base_url() . 'index.php/index_controller/redirect'; ?>',
                        type: 'POST',
                        data: {'username': $username, 'password': $password},
                        success: function (data) {
                            var obj = jQuery.parseJSON(data);
                            if (obj['status'] === true)
                            {
                                bootbox.confirm({
                                    title: '<b><font color="blue">Success</font></b>',
                                    message: 'Welcome ' + $username,
                                    callback: function () {
                                        window.location.href = '<?php echo base_url() . 'index.php/admin_controller/index'; ?>';
                                    }
                                });

                            }
                            else
                            {
                                bootbox.alert({
                                    title: '<b><font color="red">Error</font></b>',
                                    message: 'Invalid username or password! Please try again!'
                                });
                                $('#frmadmin').find('#txtUsername').val('');
                                $('#frmadmin').find('#txtPassword').val('');
                            }
                        }
                    });
                }
            });
        });
    </script> 
</html>


