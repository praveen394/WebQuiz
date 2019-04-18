<?php
$number_of_correct = ($result['correct'] / 10);
$number_of_incorrect = $result['incorrect'];
$counter = 0;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="/cw/assets/css/bootstrap.css" rel="stylesheet">
        <script src="/cw/js/jquery-2.1.4.js"></script>
        <script src="/cw/assets/js/bootstrap.js"></script>
        <script src="/cw/js/bootbox.min.js"></script>
        <title>Quiz Results</title>
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
                    <div class="col-md-2">
                        <h1>Results</h1>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="container">
                    <div class="jumbotron">
                        <div class="row">
                            <div class="col-md-6">
                                <h3><u><?php echo $result['player']."'s Result" ?></u></h3>
                                <h3><?php echo $result['message']; ?></h3>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-condensed">
                                    <caption>Previous Scores</caption>
                                    <tr>
                                        <th>Score</th>
                                        <th>User</th>
                                    </tr>
                                    <?php
                                    $rownum = 1;
                                    foreach ($result['scores'] as $score) {
                                        echo '<tr>'
                                        . '<td>' . $score->score . '</td>'
                                        . '<td>' . $score->username . '</td>'
                                        . '</tr>';
                                        $rownum++;
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h3><?php echo 'You scored : ' . $result['correct'] . ' marks'; ?></h3><br>
                                <h3><?php echo 'Incorrect Answers : ' . $result['incorrect']; ?></h3><br>
                                <h3><?php echo 'You scored : ' . $number_of_correct . '/' . $result['total']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="jumbotron">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($number_of_correct < 10) {

                                    echo '<h3>This is where you went wrong :</h3>' . '<br><br>';
                                    while ($counter < $number_of_incorrect) {
                                        echo '<h4><span class="glyphicon glyphicon-asterisk" aria-hidden="true">'
                                        . '</span> ' . $result['answers'][$counter]['question'] . '</h4>';
                                        echo '<div class="row"><div class="col-md-1">'
                                        . '</div><div class="col-md-8">';
                                        echo '<h4><span class="glyphicon glyphicon-remove-circle" aria-hidden="true">'
                                        . '</span> Selected Answer : ' . $result['answers'][$counter]['selected'] . '</h4>';
                                        echo '<h4><span class="glyphicon glyphicon-ok-circle" aria-hidden="true">'
                                        . '</span> Correct Answer : ' . $result['answers'][$counter]['answer'] . '</h4><br>';
                                        echo '</div></div>';
                                        $counter++;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                            </div>
                            <div class="col-md-2">
                                <form method="post" id="results_form" action="/cw/index.php/Index_Controller/quiz">
                                    <input type="submit" class="btn btn-success btn-lg" name="restart" value="Play Again"/>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <form method="post" id="results_form" action="/cw/index.php/Index_Controller/index">
                                    <input type="submit" class="btn btn-success btn-lg" name="restart" value="Main Menu"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>