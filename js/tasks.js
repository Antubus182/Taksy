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
const regex = /([a-zA-Z]+)-*(\d*)-*(\d*)/g;
var token="not back";
$('button').click(function(){
    //console.log(this.id);
    var str=this.id;
    console.log(str);
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
        console.log("No action Needed");

    }

}
});


function addProject(userId){
    ProjectName=document.getElementById('Projectname'+userId).value;
    ProjectDes=document.getElementById('ProjectDescription'+userId).value;
    console.log(ProjectName+" gaat over "+ProjectDes);

    $.post("updateProfile.php",
    {
        updateTask:6,
        userId:userId,
        ProjectName:ProjectName,
        ProjectDescription:ProjectDes
    },
    function(data,status){
        console.log(status);
        console.log(data);
        if(status=='success'){
            location.reload();
        }
    });
}

function addTask(projectId){
    taskTitle=document.getElementById('taskTitle'+projectId).value;
    taskColor=document.getElementById('taskColor'+projectId).value;
    console.log(taskTitle+" krijgt kleur "+taskColor);

    $.post("updateProfile.php",
    {
        updateTask:5,
        projectId:projectId,
        taskColor:taskColor,
        taskName:taskTitle
    },
    function(data,status){
        console.log(status);
        console.log(data);
        if(status=='success'){
            location.reload();
        }
    });
}

function addSub(taskId){
    subTitle=document.getElementById('subTitle'+taskId).value;
    console.log(subTitle);
    console.log(taskId);

    $.post("updateProfile.php",
    {
        updateTask:4,
        taskId:taskId,
        subName:subTitle
    },
    function(data,status){
        console.log(status);
        console.log(data);
        if(status=='success'){
            location.reload();
        }
    });
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
        if(status=="success"){
            $('#taskdone'+taskId).parent().parent().addClass("hidden");
        }
    });
}

function projectDone(projectId){
    console.log("Function called to render project complete");
    $.post("updateProfile.php",
    {
        updateTask:3,
        ProjectDoneId:projectId
    },
    function(data,status){
        console.log(data);
        console.log(status);
        if(status=='success'){
            location.reload();
        }
    });

}