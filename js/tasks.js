/*
This is old trial code
*/
$('#launch').click(function(){
    console.log("Posting to php");
    $.post("php/handler.php",
    {
        usr:"Niels",
        pass:"wachtwoord"
    },
    function(data,status){
        console.log(status);
        $('#launch').hide();
        $('#TaskyWrapper').html(data);
        new Foundation.Equalizer($("#projectContainers")).applyHeight();
        
    });
});

/*
The code below handles clicking the checkboxes, rendering a subtask done
*/

$('input:checkbox').click(function(){
    var updateTaskId=1;
    if($(this).is(":checked")){
        $(this).parent().addClass("subdone");
        var taskData=true;
    }
    else{
        $(this).parent().removeClass("subdone");
        var taskData=false;
    }
    var clicker=$(this).parent().attr('id');
    $.post("updateProfile.php",
    {
        updateTask:updateTaskId,
        clicker:clicker,
        taskData:taskData
    },
    function(data,status){
        console.log(status);
        console.log(data);
    });
});


/*
The code below desides what button was pressed to determine action
*/
const regex = /(\w+)(\d+)-*(\d*)/g;

$('button').click(function(){
    //console.log(this.id);
    var str=this.id;

    let m;

    while ((m = regex.exec(str)) !== null) {
    // This is necessary to avoid infinite loops with zero-width matches
    if (m.index === regex.lastIndex) {
        regex.lastIndex++;
    }
    //console.log("type is: "+m[1]);
    //console.log("id1 is: "+m[2]);
    //console.log("id2 is: "+m[3]);
    switch(m[1]){
        case "donetask":
        taskDone(m[3]);
        $(this).parent().addClass("hidden");
        break;
        case "sub":
        addSub(m[3]);
        break;
        case "taskadd":
        addTask(m[2]);
        break;
        case "projectdone":
        projectDone(m[2]);
        break;
        case "addProject":
        addProject(m[2]);
        break;
        default:
        console.log("unidentified button");

    }

}
});


function addProject(userId){
    console.log("function to call en projectadd");
}

function addTask(projectId){
    console.log("function called to add a task");
}

function addSub(taskId){
    console.log("function to add a subtask");
}

function taskDone(taskId){
    console.log("taskdone function called");
    $.post("updateProfile.php",
    {
        updateTask:2,
        idToUse:taskId
    },
    function(data,status){
        console.log(data);
        console.log(status);
    });
}

function projectDone(projectId){
    console.log("Function called to render project complete");
    $.post("updateProfile.php",
    {
        updateTask:3,
        idToUse:projectId
    },
    function(data,status){
        console.log(data);
        console.log(status);
    });

}