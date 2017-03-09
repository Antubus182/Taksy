<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tasky by Niels</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/tasky.css">

    <link rel="shortcut icon" href="css/favicon.ico" type="image/x-icon">
  </head>
  <body>
    
    <div class="off-canvas-wrapper">
      <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
        <div class="off-canvas position-left reveal-for-large" id="my-info" data-off-canvas data-position="left">
          <div class="row column">
            <br>
            <img class="thumbnail" id="gebr" src="http://placehold.it/550x350">
            <h5>Tasky User</h5>
            <p>Hier kan een mooi stukje staan over de huidige gebruiker, alternatief is een lijst met alle huidige projecten</p>
          </div>
          <div class="row column">
            <br>
            <button type="button" id="knop1" class="success button">+ Add Project</button>
            <p>Dit is een mooie knop plaats voor add Project</p>
          </div>
        </div>

        <div class="off-canvas-content" data-off-canvas-content>
          <div class="title-bar hide-for-large">
            <div class="title-bar-left">
              <button class="menu-icon" type="button" data-open="my-info"></button>
              <span class="title-bar-title">Tasky User</span>
            </div>
          </div>
          <div class="callout primary">
            <div class="row column">
              <h1>Welkom to Tasky Projectmanager</h1>
              <p class="lead">This project is under development but should eventualy allow you to keep track of differtent tasks in different projects</p>
            </div>
          </div>
          

          <div id="projectContainers">
            <div class="callout alert">
              <div class="row column clearfix">
                <h1 id="p1" class="float-left">Tasky ontwikkeling</h1><button type="button" id="taskknop1" class="success button float-right">+ Add Task</button>
              </div>
              <hr>
              <div class="row small-up-2 medium-up-3 large-up-4" data-equalizer data-equalize-by-row="true">
                <div class="column">
                  <div class="taskslip yellow" data-equalizer-watch>
                    <h5>Task1</h5>
                    <ul>
                      <li>subtask1</li>
                      <li>subtask2</li>
                    </ul>
                      <button type="button" id="sub1-1" class="alert button">+ Add subtask</button>
                  </div>
                </div>
                <div class="column">
                  <div class="taskslip green" data-equalizer-watch>
                    <h5>Task 2</h5>
                    <ul>
                      <li>subtask1</li>
                      <li>subtask2</li>
                      <li>Subtask3</li>
                    </ul>
                    <button type="button" id="sub1-2" class="alert button">+ Add subtask</button>
                  </div>
                </div>
                <div class="column">
                  <div class="taskslip red" id="task1-3" data-equalizer-watch>
                    <h5>Task 3</h5>
                    <ul>
                      <li>subtask1</li>
                      <li>subtask2</li>
                      <li>Subtask3</li>
                    </ul>
                    <button type="button" id="sub1-3" class="alert button">+ Add subtask</button>
                  </div>
                </div>
                <div class="column">
                  <div class="taskslip blue" data-equalizer-watch>
                    <h5>Task 4</h5>
                    <ul>
                      <li>subtask1</li>
                      <li>subtask2</li>
                      <li>Subtask3</li>
                      <li>subtask1</li>
                      <li>subtask2</li>
                      <li>Subtask3</li>
                    </ul>
                    <button type="button" id="sub1-4" class="alert button">+ Add subtask</button>
                  </div>
                </div>
              </div>
            </div>

            <hr>
            <div class="callout alert">
              <div class="row column clearfix">
                <h1 id="p2" class="float-left">Nanobay taken</h1><button type="button" id="taskknop2" class="success button float-right">+ Add Task</button>
              </div>
              <hr>
              <div class="row small-up-2 medium-up-3 large-up-4" data-equalizer data-equalize-by-row="true">
                <div class="column">
                  <div class="taskslip yellow" data-equalizer-watch>
                    <h5>Task1</h5>
                    <ul>
                      <li>subtask1</li>
                      <li>subtask2</li>
                    </ul>
                      <button type="button" id="sub2-1" class="alert button">+ Add subtask</button>
                  </div>
                </div>
                <div class="column">
                  <div class="taskslip green" data-equalizer-watch>
                    <h5>Task 2</h5>
                    <ul>
                      <li>subtask1</li>
                      <li>subtask2</li>
                      <li>Subtask3</li>
                    </ul>
                    <button type="button" id="sub2-2" class="alert button">+ Add subtask</button>
                  </div>
                </div>
                <div class="column">
                  <div class="taskslip red" id="poster" data-equalizer-watch>
                    <h5>Task 3</h5>
                    <ul>
                      <li>subtask1</li>
                      <li>subtask2</li>
                      <li>Subtask3</li>
                    </ul>
                    <button type="button" id="sub2-3" class="alert button">+ Add subtask</button>
                  </div>
                </div>
                <div class="column">
                  <div class="taskslip blue" data-equalizer-watch>
                    <h5>Task 4</h5>
                    <ul>
                      <li>subtask1</li>
                      <li>subtask2</li>
                      <li>Subtask3</li>
                      <li>subtask1</li>
                      <li>subtask2</li>
                      <li>Subtask3</li>
                    </ul>
                    <button type="button" id="sub2-4" class="alert button">+ Add subtask</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/foundation.js"></script>
    <script src="js/tasks.js"></script>
    <script>
      $(document).foundation();
    </script>


  </body>
</html>    