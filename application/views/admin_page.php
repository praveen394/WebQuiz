<html>
    <head>
        <link href="/cw/assets/css/bootstrap.css" rel="stylesheet">
        <script src="/cw/js/jquery-2.1.4.js"></script>
        <script src="/cw/assets/js/bootstrap.js"></script>
        <script src="/cw/js/bootbox.min.js"></script>
        <title>Admin Panel</title>
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
                        <h1>Admin Panel</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="pull-right">
                        <button type="button" id="btnSignout" name="btnSignout" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-off" aria-hidden="true"> Logout</span></button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-2"></div>
                <div class="col-md-6">

                </div>
                <div class="col-md-3 pull-right">
                    <button type="button" id="btnAdd" name="btnAdd" class="btn btn-primary" data-target="#add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Question</button>
                    <button type="button" id="btnEdit" name="btnEdit" class="btn btn-primary" data-target="#edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit Question</button>
                </div>
                <div class="jumbotron">
                    <table class="table table-striped">
                        <tr>
                            <th>Question ID</th>
                            <th>Questions</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        foreach ($all['questions'] as $questionRow) {
                            echo '<tr>';
                            echo '<td>' . $questionRow->id . '</td>';
                            echo '<td>' . $questionRow->text . '</td>';
                            echo '<td>';
                            echo ' <a href="#" data-option="1" id="loadAnswers" data-id="' . $questionRow->id . '" data-target="#delete"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>';
                            echo ' <a href="#" data-option="2" id="loadDelete" data-id="' . $questionRow->id . '" data-target="#delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <div id="add" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Question</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmAdd" name="frmAdd" action="/cw/index.php/admin/post">
                            <div class="form-group row">
                                <label for="txtQuestion" class="col-sm-2 form-control-label">Question</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtQuestion" name="txtQuestion" class="form-control" placeholder="Question"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtAnswer1" class="col-sm-2 form-control-label">Choice 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtAnswer1" name="txtAnswer1" placeholder="Answer 1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtAnswer2" class="col-sm-2 form-control-label">Choice 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtAnswer2" name="txtAnswer2" placeholder="Answer 2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtAnswer3" class="col-sm-2 form-control-label">Choice 3</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtAnswer3" name="txtAnswer3" placeholder="Answer 3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtAnswer4" class="col-sm-2 form-control-label">Choice 4</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtAnswer4" name="txtAnswer4" placeholder="Answer 4">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="drpAns" class="col-sm-2 form-control-label">Correct Answer</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="drpAns" name="drpAns">
                                        <option value="1">Answer 1</option>
                                        <option value="2">Answer 2</option>
                                        <option value="3">Answer 3</option>
                                        <option value="4">Answer 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" id="btnSave" class="btn btn-secondary">Save</button>
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

        <div id="edit" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Question</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmEdit" name="frmEdit" action="/cw/index.php/admin/put">
                            <div class="form-group row">
                                <label for="txtEQuestionId" class="col-sm-2 form-control-label">Question</label>
                                <div class="col-sm-10">
                                    <input type="number" id="txtEQuestionId" name="txtEQuestionId" class="form-control" placeholder="QuestionID"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtQuestion" class="col-sm-2 form-control-label">Question</label>
                                <div class="col-sm-10">
                                    <input type="text" id="txtEQuestion" name="txtEQuestion" class="form-control" placeholder="Question"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtEAnswer1" class="col-sm-2 form-control-label">Choice 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtEAnswer1" name="txtEAnswer1" placeholder="Answer 1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtEAnswer2" class="col-sm-2 form-control-label">Choice 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtEAnswer2" name="txtEAnswer2" placeholder="Answer 2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtEAnswer3" class="col-sm-2 form-control-label">Choice 3</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtEAnswer3" name="txtEAnswer3" placeholder="Answer 3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtEAnswer4" class="col-sm-2 form-control-label">Choice 4</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtEAnswer4" name="txtEAnswer4" placeholder="Answer 4">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="drpEAns" class="col-sm-2 form-control-label">Correct Answer</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="drpEAns" name="drpEAns">
                                        <option value="1">Answer 1</option>
                                        <option value="2">Answer 2</option>
                                        <option value="3">Answer 3</option>
                                        <option value="4">Answer 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" id="btnUpdate" class="btn btn-secondary">Update</button>
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

        <div id="view" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">View Question</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmView" name="frmEdit" action="/cw/index.php/admin/put">
                            <div class="form-group row">
                                <label for="txtView1" class="col-sm-2 form-control-label">Answer 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtView1" name="txtView1" disabled="disabled" placeholder="Answer 1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtView2" class="col-sm-2 form-control-label">Answer 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtView2" name="txtView2" disabled="disabled" placeholder="Answer 2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtView3" class="col-sm-2 form-control-label">Answer 3</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtView3" name="txtView3" disabled="disabled" placeholder="Answer 3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtView4" class="col-sm-2 form-control-label">Answer 4</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtView4" name="txtView4" disabled="disabled" placeholder="Answer 4">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtAnswer" class="col-sm-2 form-control-label">Correct Answer</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txtAnswer" name="txtAnswer" disabled="disabled" placeholder="Correct Answer">
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


        <script type="text/javascript">
            $(document).ready(function () {
                //sign out function: confirms and redirects to index
                $('#btnSignout').unbind('click').bind('click', function () {
                    bootbox.confirm({
                        title: '<b><font color="red">Warning!</font></b>',
                        message: 'Are you sure?',
                        callback: function () {
                            window.location.href = '<?php echo base_url() . 'index.php/index_controller/index'; ?>';
                        }
                    });
                });
                //show add modal
                $('#btnAdd').unbind('click').bind('click', function () {
                    $('#add').modal();
                    $('#add').show();
                });
                //show edit modal
                $('#btnEdit').unbind('click').bind('click', function () {
                    $('#edit').modal();
                    $('#add').show();
                });
                //save question function
                $('#add').find('#btnSave').unbind('click').bind('click', function () {
                    $question = $('#frmAdd').find('#txtQuestion').val();
                    $choice1 = $('#frmAdd').find('#txtAnswer1').val();
                    $choice2 = $('#frmAdd').find('#txtAnswer2').val();
                    $choice3 = $('#frmAdd').find('#txtAnswer3').val();
                    $choice4 = $('#frmAdd').find('#txtAnswer4').val();
                    $correctAns = $('#frmAdd').find('#drpAns').val();
                    //validation
                    if ($question == '' || $choice1 == '' || $choice2 == '' || $choice3 == '' || $choice4 == '')
                    {
                        bootbox.alert({
                            title: '<b><font color="red">Error</font></b>',
                            message: 'Fields can not be empty!'
                        });
                    }
                    else
                    {
                        $.ajax({
                            url: '<?php echo base_url() . 'index.php/API_controller/question'; ?>',
                            type: 'POST',
                            data: {
                                'question': $question,
                                'choice1': $choice1,
                                'choice2': $choice2,
                                'choice3': $choice3,
                                'choice4': $choice4,
                                'correctAns': $correctAns
                            },
                            success: function (data)
                            {
                                var obj = jQuery.parseJSON(data);
                                if (obj['status'] === true)
                                {
                                    bootbox.confirm({
                                        title: '<b><font color="blue">Success</font></b>',
                                        message: '<b>Insert Successful!</b>',
                                        callback: function () {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    bootbox.alert({
                                        title: '<b><font color="red">Error</font></b>',
                                        message: 'Insert failed.'
                                    });
                                }
                            }
                        });
                    }
                });
                //options from the table
                $('a').unbind('click').bind('click', function () {
                    $choice = $(this).data("option");
                    $id = $(this).data("id");
                    //view function
                    if ($choice == 1)
                    {
                        $('#view').modal();
                        $.ajax({
                            url: '<?php echo base_url() . 'index.php/API_controller/question'; ?>',
                            type: 'GET',
                            dataType: 'json',
                            data: {'questionId': $id},
                            success: function (data)
                            {
                                $correctAns = '';
                                for ($i = 1; $i < 5; $i++)
                                {
                                    if (data['single'][$i]['correct'] == '1')
                                    {
                                        $correctAns = data['single'][$i]['text'];
                                    }
                                }
                                $ans1 = data['single'][1]['text'];
                                $ans2 = data['single'][2]['text'];
                                $ans3 = data['single'][3]['text'];
                                $ans4 = data['single'][4]['text'];
                                //display data to form
                                $('#frmView').find('#txtView1').val($ans1);
                                $('#frmView').find('#txtView2').val($ans2);
                                $('#frmView').find('#txtView3').val($ans3);
                                $('#frmView').find('#txtView4').val($ans4);
                                $('#frmView').find('#txtAnswer').val($correctAns);
                            }
                        });
                        $('#view').show();
                    }
                    else {
                    //delete function
                        $.ajax({
                            url: '<?php echo base_url() . 'index.php/API_controller/question'; ?>',
                            type: 'DELETE',
                            data: {'questionId': $id},
                            success: function (data)
                            {
                                var obj = jQuery.parseJSON(data);
                                if (obj['status'] === true)
                                {
                                    bootbox.confirm({
                                        title: '<b><font color="red">Warning</font></b>',
                                        message: '<b>Are you sure you want to delete?</b>',
                                        callback: function () {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    bootbox.alert({
                                        title: '<b><font color="red">Error</font></b>',
                                        message: 'Delete failed.'
                                    });
                                }
                            }
                        });
                    }
                });
                //update button function
                $('#edit').find('#btnUpdate').unbind('click').bind('click', function () {
                    $questionID = $('#frmEdit').find('#txtEQuestionId').val();
                    $question = $('#frmEdit').find('#txtEQuestion').val();
                    $choice1 = $('#frmEdit').find('#txtEAnswer1').val();
                    $choice2 = $('#frmEdit').find('#txtEAnswer2').val();
                    $choice3 = $('#frmEdit').find('#txtEAnswer3').val();
                    $choice4 = $('#frmEdit').find('#txtEAnswer4').val();
                    $correctAns = $('#frmEdit').find('#drpEAns').val();
                    //validation
                    if ($questionID == '' || $question == '' || $choice1 == '' || $choice2 == '' || $choice3 == '' || $choice4 == '')
                    {
                        bootbox.alert({
                            title: '<b><font color="red">Error</font></b>',
                            message: 'Fields can not be empty!'
                        });
                    }

                    $.ajax({
                        url: '<?php echo base_url() . 'index.php/API_controller/question'; ?>',
                        type: 'PUT',
                        data: {
                            'questionID': $questionID,
                            'question': $question,
                            'choice1': $choice1,
                            'choice2': $choice2,
                            'choice3': $choice3,
                            'choice4': $choice4,
                            'correctAns': $correctAns
                        },
                        success: function (data)
                        {
                            var obj = jQuery.parseJSON(data);
                            if (obj['status'] === true)
                            {
                                bootbox.confirm({
                                    title: '<b><font color="blue">Success</font></b>',
                                    message: '<b>Update Successful!</b>',
                                    callback: function () {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                bootbox.alert({
                                    title: '<b><font color="red">Error</font></b>',
                                    message: 'Update failed.'
                                });
                            }
                        }
                    });
                });
            });
        </script>

    </body>
</html>
