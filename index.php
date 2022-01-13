<?php

require "db_connection.php";
require "data_model/obligations.php";
require "data_model/subjects.php";

session_start();

$result = Obligation::getAll($connection);
$resultSubjects = Subject::getAll($connection);

if (!$result) {
    echo "Nastala je greška pri izvođenju upita<br>";
    die();
}
if ($result->num_rows == 0)
{
    echo "No available tasks!";
    die();

}
else {



?>

<!DOCTYPE html>
<html>

<head>
  <title>UTT</title>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>           
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <style>
    .card:hover {
      transform: translateY(-0.7rem);
    }
  
  </style>
</head>

<body>
  <nav>
    <div class="nav-wrapper blue darken-3 z-depth-1">
      <a href="#" class="brand-logo"><i class="material-icons left">school</i> University Tasks Tracker</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="index.php">Obligations</a></li>
        <li><a href="subject_page.php">Subjects</a></li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <div class="card blue darken-1 z-depth-3">
          <div class="card-action white-text">
            <div class="input-field col s6">
              <i style="color: #1a237e " class="material-icons prefix">search</i>
              <input id="icon_prefix" type="text" class="search" value="">
              <label style="color: #1a237e " for="icon_prefix">Search here...</label>
            </div>
            <ul>
              <li><span style="color: #1a237e ">Sort by: </span></li>
              <li class="btnSortDate waves-effect indigo darken-2 btn"><i class="material-icons left">date_range</i>Date</li>
              <li class="btnSortFinished waves-effect indigo darken-2 btn"><i class="material-icons left">check</i>Is Done</li>
              <li class="waves-effect waves-light modal-trigger btn" id="addTask"><i class="material-icons left">plus_one</i>Add</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <ul class="gradient-list">
    <div class="row allTasks"><?php
            while ($red = $result->fetch_array()) {
                ?>
      <li class="taskCard" id="<?php echo $red["id"]?>">
        
          <div class="col s12 m6 cards-container">
            <div class="card blue darken-1 z-depth-3">
              <div class="card-content white-text">
                <h3 class="card-title"><b><?php echo $red["task_name"] ?></b></h3>
                <p>Description: <?php echo $red["description"] ?><br></p>
                <p class="dateToSort">Date: <?php echo $red["date"]?><br></p>
                <p class="finishedToSort">Is Done:<b> <?php if($red["isDone"] == 1) {
                  echo "Finished";
                } else {echo "Not Finished";}  ?></b><br></p>
                <p>Subject: <?php echo $red["subject_name"] ?><br></p>
              </div>
              <div class="card-action">
                <button class="btn-edit waves-effect modal-trigger indigo darken-1 btn"><i class="material-icons left">create</i>Edit</button>
                <button class="btn-delete waves-effect red darken-1 btn"><i class="material-icons left">delete</i>Delete</button>
              </div>
            </div>
          </div>
        
      </li>
      <?php }?></div>
    </ul>

  </div>

  <!-- Modal -->
  <div class="modal fade" id="addModal" role="dialog" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="waves-effect red darken-2 btn" id="closeAddModal" data-dismiss="modal"><i class="material-icons">close</i></button>
        </div>
        <div class="modal-body">
          <div class="container add-task-form">
              <form action="#" method="post" id="addTaskForm">
                  <h3 style="color: black">Adding Task</h3>
                  <div class="row">
                      <div >
                        <div class="form-group">
                            <input type="text" style="border: 1px solid black" name="name" class="form-control" placeholder="Task Name*" value=""/>
                        </div>
                        <div class="form-group">
                            <textarea type="text" style="border: 1px solid black" name="description" class="form-control" placeholder="Description*" value=""></textarea>
                        </div>
                        <div class="form-group">
                            <input type="date" style="border: 1px solid black" name="date" class="form-control" placeholder="Date*" value=""/>
                        </div>
                        <div class="form-group">
                          <!--<input type="number" style="border: 1px solid black" name="isDone" class="form-control" placeholder="Is Done?(0-false, 1-true)*" value=""/>-->
                          <div class="switch">
                            <label> Not Finished
                              <input type="checkbox" class="doneSwitch">
                              <span class="lever"></span> Finished
                            </label>
                          </div>
                        </div>
								        <div class="form-group">
                          <select type="number" style="border: 1px solid black" name="subject_id" class="form-control" placeholder="Select a subject*" value="">
                            <?php
                                while ($redSub = $resultSubjects->fetch_array()) { ?>
                            <option value="<?php echo $redSub["subject_id"];?>"><?php echo $redSub["subject_name"];?></option>
                            <?php };?>
									        </select>
                        </div>
                        <div class="form-group">
                          <button id="btnAddTask" type="submit" class="waves-effect indigo darken-2 btn">Add Task</button>
                        </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="waves-effect red darken-2 btn" id="exitAddModal" data-dismiss="modal">Exit</button>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade" id="editModal" role="dialog" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="waves-effect red darken-2 btn" id="closeEditModal" data-dismiss="modal"><i class="material-icons">close</i></button>
        </div>
        <div class="modal-body">
          <div class="container edit-task-form">
              <form action="#" method="post" id="editTaskForm">
                  <h3 style="color: black">Editing Task</h3>
                  <div class="row">
                      <div >
                        <div class="form-group">
                          <input id="name" type="text" style="border: 1px solid black" name="name" class="form-control" placeholder="Task Name*" value=""/>
                        </div>
                        <div class="form-group">
                          <textarea id="description" type="text" style="border: 1px solid black" name="description" data-length="240" class="form-control" placeholder="Description*" value=""></textarea>
                        </div>
                        <div class="form-group">
                          <input id="date" type="date" style="border: 1px solid black" name="date" class="form-control" placeholder="Date*" value=""/>
                        </div>
                        <div class="form-group">
                          <div class="switch">
                            <label> Not Finished
                              <input type="checkbox" class="doneSwitch" value="">
                              <span class="lever"></span> Finished
                            </label>
                          </div>
                        </div>
								        <div class="form-group">
                          <select id="subject_id" type="number" style="border: 1px solid black" name="subject_id" class="form-control" placeholder="Select a subject*" value="">
                          <?php
                                $resultSubjects = Subject::getAll($connection);
                                while ($redSub = $resultSubjects->fetch_array()) { ?>
                            <option value="<?php echo $redSub["subject_id"];?>"><?php echo $redSub["subject_name"];?></option>
                            <?php }}?>
									        </select>
                        </div>
                        <div class="form-group">
                          <button id="btnEditTask" type="submit" class="waves-effect indigo darken-2 btn">Edit Task</button>
                        </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="waves-effect red darken-2 btn" id="exitEditModal" data-dismiss="modal">Exit</button>
      </div>
    </div>
  </div>
</div>

<script defer type="text/javascript" src="js/script.js?newVersion"></script>
</body>

</html>