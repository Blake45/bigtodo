$(document).ready(function(){

    $('select').material_select();

    //todo creation of tache
    $('#add-task').click(function(e){
        $('#modal-new-task').openModal();
    });

    //todo glisser tache
    $( ".draggable" ).draggable({
        revert:function(event) {
            console.log(event);
            if(!event.hasClass('yes')){
                return true;
            }
        }
    });
    $(".droppable").droppable({
        hoverClass: "z-depth-1",
        accept: ".draggable"
    });

});
