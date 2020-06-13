let toggleMenu = () => {
    $('#sidebar').toggleClass('toggleActive');
}


let setTargetSituation = (targetSituationId) => {
    $targetSituationElement = document.getElementById('targetSituation');
    $targetSituationElement.value = targetSituationId;
    console.log([$targetSituationElement.value]);
}