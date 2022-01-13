<?php

require "../db_connection.php";
require "../data_model/subjects.php";

session_start();

$result = Subject::getAll($connection);

if (!$result) {
    echo "Nastala je greška pri izvođenju upita<br>";
    die();
}
if ($result->num_rows == 0)
{
    echo "Nema predmeta";
    die();

}
else {



?>

<div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog">

        <div class="modal-content" style="border: 3px solid orange;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container sir-form">
                    <form action="#" method="post" id="dodajForm">
                        <h3 style="color: black">Adding Task</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" style="border: 1px solid black" name="taskName" class="form-control"
                                           placeholder="Task Name*" value=""/>
                                </div>
                                <div class="form-group">
                                    <input type="text" style="border: 1px solid black" name="description" class="form-control" placeholder="Description*"
                                           value=""/>
                                </div>
                                <div class="form-group">
                                    <input type="datetime-local" style="border: 1px solid black" name="taskDate" class="form-control"
                                           placeholder="Date*" value=""/>
								</div>
								<div class="form-group">
                                    <input type="number" style="border: 1px solid black" name="taskIsDone" class="form-control"
                                           placeholder="Is Done?*" value=""/>
								</div>
								<div class="form-group">
                                    <select type="number" style="border: 1px solid black" name="subjects" class="form-control"
                                           value="">
                                           <?php
                                                while ($red = $result->fetch_array()) {
                                                    ?>
                                            <option name="<?php $red["name"]?>"><?php echo $red["name"]?></option>
                                            <?php }}?>
									</select>
                                </div>
                                <div class="form-group">
                                    <button id="btnDodaj" type="submit" class="btn btn-success btn-block"
                                            style="background-color: orange; border: 1px solid black;"><i
                                                class="glyphicon glyphicon-plus"></i> Add Task
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="color: white; background-color: orange; border: 1px solid white" data-dismiss="modal">Exit</button>
            </div>
        </div>

    </div>
</div>
