const toggleMenu = () => {
    $('#sidebar').toggleClass('toggleActive');
}


const setTargetSituation = (targetSituationId) => {
    $targetSituationElement = document.getElementById('targetSituation');
    $targetSituationElement.value = targetSituationId;
    console.log([$targetSituationElement.value]);
}

const openProjectForm = () => {
    let projectFormRow = document.getElementById('projectFormRow');
    projectFormRow.classList.toggle('hidden');
}

const onSubmitLogic = () => {
    let projectFormRow = document.getElementById('projectFormRow');
    let considerProjectForm = document.getElementById('considerProjectForm');
    if(projectFormRow.classList.contains("hidden")){
        considerProjectForm.value = 0;
    } else {
        considerProjectForm.value = 1;
    }
}

const showViewInsertTask = () => {
    let projectFormRow = document.getElementById('insertTaskForm');
    projectFormRow.classList.toggle('hidden');
}