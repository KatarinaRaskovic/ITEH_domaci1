<?php

require "db_connection.php";
require "data_model/subjects.php";

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
    <div class="nav-wrapper blue darken-3">
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
        <div class="card blue darken-1">
          <div class="card-action white-text">
            <div class="input-field col s6">
              <i style="color: #1a237e " class="material-icons prefix">search</i>
              <input id="icon_prefix" type="text" class="search">
              <label style="color: #1a237e " for="icon_prefix">Search here...</label>
            </div>
            <ul>
              <li><span style="color: #1a237e ">Sort by:</span></li>
              <li class="btnSortEspb waves-effect indigo darken-2 btn"><i class="material-icons left">subject</i>ESPB</li>
              <li class="btnSortSemester waves-effect indigo darken-2 btn"><i class="material-icons left">format_list_numbered</i>Semester</li>
              <li class="waves-effect waves-light btn" id="addSubject"><i class="material-icons left">plus_one</i>Add</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <ul class="gradient-list">
    <div class="row allSubjects"><?php
            while ($red = $result->fetch_array()) {
                ?>
      <li id="<?php echo $red["subject_id"]?>" class="subjectCard">
        
      <div class="col s12 m6 cards-container">
            <div class="card blue darken-1 z-depth-3">
              <div class="card-content white-text">
                <h3 class="card-title"><b><?php echo $red["subject_name"] ?></b></h3>
                <p class="espbToSort">ESPB: <?php echo $red["espb"] ?><br></p>
                <p class="semesterToSort">Semester: <?php echo $red["semester"] ?><br></p>
              </div>
              <div class="card-action">
                <button class="btn-edit waves-effect indigo darken-1 btn"><i class="material-icons left">create</i>Edit</button>
                <button class="btn-delete waves-effect red darken-1 btn"><i class="material-icons left">delete</i>Delete</button>
              </div>
            </div>
          </div>
        
      </li>
            <?php }}?></div>
    </ul>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="addModal" role="dialog" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="waves-effect red darken-2 btn" id="closeAddModal" data-dismiss="modal"><i class="material-icons">close</i></button>
        </div>
        <div class="modal-body">
          <div class="container add-task-form">
              <form action="#" method="post" id="addSubjectForm">
                  <h3 style="color: black">Adding Subject</h3>
                  <div class="row">
                      <div >
                        <div class="form-group">
                            <input type="text" style="border: 1px solid black" name="name" class="form-control" placeholder="Subject Name*" value=""/>
                        </div>
                        <div class="form-group">
                            <input type="number" style="border: 1px solid black" name="espb" class="form-control" placeholder="ESPB*" value=""/>
                        </div>
                        <div class="form-group">
                            <input type="number" style="border: 1px solid black" name="semester" class="form-control" placeholder="Semester*" value=""/>
                        </div>
                        <div class="form-group">
                          <button id="btnAddSubject" type="submit" class="waves-effect indigo darken-2 btn">Add Subject</button>
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
              <form action="#" method="post" id="editSubjectForm">
                  <h3 style="color: black">Editing Task</h3>
                  <div class="row">
                  <div class="form-group">
                            <input id="name" type="text" style="border: 1px solid black" name="name" class="form-control" placeholder="Subject Name*" value=""/>
                        </div>
                        <div class="form-group">
                            <input id="espb" type="number" style="border: 1px solid black" name="espb" class="form-control" placeholder="ESPB*" value=""/>
                        </div>
                        <div class="form-group">
                            <input id="semester" type="number" style="border: 1px solid black" name="semester" class="form-control" placeholder="Semester*" value=""/>
                        </div>
                        <div class="form-group">
                          <button id="btnEditSubject" type="submit" class="waves-effect indigo darken-2 btn">Edit Subject</button>
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
<script defer type="text/javascript" src="js/subject_script.js?newVersion"></script>
</body>

</html>