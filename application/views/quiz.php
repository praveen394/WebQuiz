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
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-3">
                        <h1>Harry Potter Quiz</h1>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="container">
                    <div class="jumbotron">
                        <div class="row">
                            <form method="POST" id="quiz_form" action="/cw/index.php/Index_Controller/results">
                                <?php
                                $question_number = 1;
                                $ansId = array();
                                foreach ($quiz as $row) {
                                    $answer_number = 0;
                                    echo '<div class="form-group"><div class="row">'
                                    . '<div class="col-md-12">';
                                    echo '<h3>' . $question_number . '. '
                                    . $row['text'] . '</h3>';
                                    echo '</div></div>';
                                    $answer_number = $row['id'];
                                    $first = true;
                                    foreach ($row['ans'] as $value) {
                                        if ($first) {
                                            echo '<div class="row"><div class="col-md-8">';
                                            echo '<h4><input type="radio" checked="checked"  '
                                            . 'name=' . $question_number
                                            . ' value= ' . $answer_number . ','
                                            . $value['ansid'] . ' /> '
                                            . $value['choice'] . '</h4>';
                                            echo '</div></div>';
                                            $first = false;
                                        } else {
                                            echo '<div class="row"><div class="col-md-8">';
                                            echo '<h4><input type="radio"  '
                                            . 'name=' . $question_number
                                            . ' value= ' . $answer_number . ','
                                            . $value['ansid'] . ' /> '
                                            . $value['choice'] . '</h4>';
                                            echo '</div></div>';
                                        }
                                    }
                                    echo '</div>';
                                    $question_number++;
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-2">
                                        <input type="submit" id="btncheck" name="test" class="btn btn-primary btn-lg" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>