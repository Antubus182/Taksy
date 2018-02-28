<?php
//this file creates the actual html file

function generatePage($projectData,$usr){
  $config=json_decode(file_get_contents("../config.json"));
  $startingHtml='<!doctype html>
                    <html class="no-js" lang="en">
                    <head>
                      <meta charset="utf-8" />
                      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                      <title>Tasky by Niels</title>
                      <link rel="stylesheet" href="../css/foundation-icons.css">
                      <link rel="stylesheet" href="../css/foundation.css">
                      <link rel="stylesheet" href="../css/tasky.css">

                      <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
                    </head>
                    <body>
                      <div id="TaskyWrapper" class="off-canvas-wrapper"></div>
                        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>';

  $modalHtml=buildprojectModal($usr->id);

  $menuHtml='
    <div class="off-canvas position-left reveal-for-large" id="my-info" data-off-canvas data-position="left">
          <div class="row column">
            <br>
            <img class="thumbnail" id="gebr" src="../img/User_image/profile.jpg">
            <h5>Welcome '.$usr->name.'</h5>
            <p>'.$usr->about.'</p>
            <a type="button" href="logout.php" id="logout" class="alert button">Logout</a>
          </div>
          <div class="row column">
            <br>
            <button type="button" id="addProjectm'.$usr->id.'" class="success button" data-open="addProjectModal'.$usr->id.'">+ Add Project</button>
          </div>
        </div>

        <div class="off-canvas-content" data-off-canvas-content>
          <div class="title-bar hide-for-large">
            <div class="title-bar-left">
              <button class="menu-icon" type="button" data-open="my-info"></button>
              <span class="title-bar-title">Menu</span>
            </div>
          </div>';

  $introHtml='
      <div class="callout primary">
            <div class="row column">
              <h1 class="welcome">Welkom to Tasky Projectmanager</h1>
              <p class="lead">'.$config->introtext.'</p>
            </div>
          </div>
  ';

  $projectlisting='<hr><div id="projectContainers">';
  if($projectData!=NULL){
    foreach($projectData as $project){
      $building='<div id="project'.$project["id"].'" class="callout groen '.count($projectData).'"><div class="row column clearfix"><h1 id="p'.$project["id"].'" class="float-left">'.$project['name'].'</h1>';
      $building.='<button type="button" id="projectDoneModalCall'.$project["id"].'" data-open="DeleteProjectModal'.$project["id"].'" class="pfin info button float-right">Project Finished</button>';
      $building.='<button type="button" id="taskaddm'.$project["id"].'" class="success button float-right" data-open="taskModal'.$project["id"].'">+ Add Task</button></div><hr>';
      $building.='<div class="row" data-equalizer="section'.$project["id"].'" data-equalize-by-row="true">';
      $modalHtml.=buildtaskModal($project["id"]);
      $modalHtml.=buildProjectKillConformationModal($project["id"]);
      foreach($project["tasks"] as $task){
        //if(!$task["done"]){
          if($task["done"]){
            $building.='<div class="column hidden"><div class="taskslip '.$task["color"].'">';
          }
          else{
            $building.='<div class="column small-12 medium-4 large-3"><div class="taskslip '.$task["color"].'" data-equalizer-watch="section'.$project["id"].'">';
          }
          //$building.='<div class="taskslip '.$task["color"].'" data-equalizer-watch="section'.$project["id"].'">';
          $building.='<h5>'.$task["tname"].'</h5><ul>';
          foreach($task["subtasks"] as $subtask){
            if($subtask["done"]){

              $building.='<li id=subtask'.$subtask["id"].' class="subdone"><input type="checkbox" checked>'.$subtask["subname"].'</li>';
            }
            else{
              $building.='<li id=subtask'.$subtask["id"].'><input type="checkbox">'.$subtask["subname"].'</li>';
            }
          }
          $building.='</ul><button type="button" id="subm'.$project["id"].'-'.$task["id"].'" class="success button" data-open="subModal'.$project["id"].'-'.$task["id"].'">+ Add subtask</button><br>';
          $building.='<button type="button" id="taskdone'.$task["id"].'" class="small alert button" data-open="DeletetaskModal'.$task["id"].'">Task completed</button>';
          $building.='</div></div>';
          $modalHtml.=buildsubModal($project["id"],$task["id"]);
          $modalHtml.=buildTaskConformationModal($task["id"],$project["id"]);
      }
      $building.='</div></div>';
      $projectlisting.=$building;
    }
  }


  $closingHtml='</div></div></div>
                  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
                  <script src="../js/foundation.js"></script>
                  <script src="../js/tasks.js"></script>
                  <script>
                  $(document).foundation();
                  </script>
                </body>';

  $completePage=$startingHtml.$menuHtml.$introHtml.$projectlisting.$modalHtml.$closingHtml;
  return $completePage;
}

function buildsubModal($projectid,$taskid){
  $leHtml='<div class="reveal bounce-in fast" data-animation-in="scale-in-up" data-animation-out="fade-out" id="subModal'.$projectid.'-'.$taskid.'" data-reveal>
                <h2>Add subTask</h2>
                <div class="row">
                <form><div class="medium-6 columns">
                <label>Subtask Name<input id="subTitle'.$taskid.'" type="text" onkeypress="enterCheckInput(event,this)"></label>
                </div></form>
                </div>
                <div class="row">
                <button id="sub'.$projectid.'-'.$taskid.'" data-close class="success button modalbutton" type="button">Add subTask</button>
                </div>
                <button class="close-button" data-close aria-label="Close screen" type="button"><span aria-hidden="true">&times;</span></button>
              </div>';
  return $leHtml;
}

function buildtaskModal($projectid){
  $leHtml='<div id="taskModal'.$projectid.'" class="reveal bounce-in fast" data-animation-in="scale-in-up" data-animation-out="fade-out" data-reveal>
    <h2>Add Task</h2>
                <div class="row">
                <form><div class="medium-6 columns">
                <label>Subtask Name<input id="taskTitle'.$projectid.'" type="text"></label>
                </div>
                <div class="medium-6 columns">
                <label>Color<select id="taskColor'.$projectid.'">
                <option value="yellow">Yellow</option>
                <option value="green">Green</option>
                <option value="red">Red</option>
                <option value="blue">Blue</option>
                <option value="grey">Grey</option>
                </select></label>
                </div>
                </form>
                </div>
                <div class="row">
                <button id="taskadd'.$projectid.'" data-close class="success button modalbutton" type="button">Add Task</button>
                </div>
    <button class="close-button" data-close aria-label="Close screen" type="button"><span aria-hidden="true">&times;</span></button>
    </div>';
  return $leHtml;
}

function buildprojectModal($userid){
  $leHtml='<div id="addProjectModal'.$userid.'" class="reveal bounce-in fast" data-reveal data-animation-in="scale-in-up" data-animation-out="fade-out">
                <h2>Add Project</h2>
                <div class="row">
                <form><div class="medium-6 columns">
                <label>Project Name<input id="Projectname'.$userid.'" type="text"></label>
                </div>
                <div class="medium-6 columns">
                <label>Project Description<textarea id="ProjectDescription'.$userid.'"></textarea>
                </div>
                </form>
                </div>
                <div class="row">
                <button id="addProject'.$userid.'" data-close class="success button modalbutton" type="button">Create Project</button>
                </div>
                    <button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>';
  return $leHtml;
}

function buildTaskConformationModal($taskId,$projectId){
  $modalHtml='<div id="DeletetaskModal'.$taskId.'" class="reveal bounce-in fast" data-reveal data-animation-in="scale-in-up" data-animation-out="fade-out">
                <h4 class="delmodal">Are you sure you want to delete this task?</h4>
                <div class="row">
                  <div class="medium-6 columns">
                  <button id="donetask'.$projectId.'-'.$taskId.'" data-close class="success button expanded modalbutton" type="button">Yes</button>
                  </div>
                  <div class="medium-6 columns">
                  <button id="cancel'.$projectId.'-'.$taskId.'" data-close class="alert button expanded modalbutton" type="button">No</button>
                  </div>
                </div>
                <button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
              </div>';

  return $modalHtml;

}

function buildProjectKillConformationModal($projectId){
    $modalHtml='<div id="DeleteProjectModal'.$projectId.'" class="reveal bounce-in fast" data-reveal data-animation-in="scale-in-up" data-animation-out="fade-out">
                  <h4>Are you sure you want to delete this project and all its tasks?</h4>
                  <div class="row">
                    <div class="medium-6 columns">
                    <button id="projectdone'.$projectId.'" data-close class="success button expanded modalbutton" type="button">Yes</button>
                    </div>
                    <div class="medium-6 columns">
                    <button id="cancelProject'.$projectId.'" data-close class="alert button expanded modalbutton" type="button">No</button>
                    </div>
                  </div>
                  <button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>';

    return $modalHtml;
}

/*
id="projectdone'.$project["id"]

$projectData is an array with all projects that need to be renderd
each project is an assocarray with the following structure:
"name"=projecttitle
"owner"=integer with project owner
"description"=a project description
"color"=a hexcolor code for the background (no #)
"tasks"= an array with the tasks
  "tname"=the task name
  "color"= an integer representing the class determining the postit color
  "done"=an integer 1 or 0 to check if the task is done
  "subtasks"= an array with subtasks
    in this array the key is the title of the subtask and the value is an integer stating wheter or not it is completed

using an assocarray instead of an object is to provide the possiblitity to in a future release directly return a json object to the javascript file
*/
?>
