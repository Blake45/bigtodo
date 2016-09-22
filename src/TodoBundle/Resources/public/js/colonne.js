$(document).ready(function(){

    $('select.materialize').material_select();

    //todo creation of tache
    $('#add-task').click(function(e){
        $('#modal-new-task').openModal();
    });

    //todo glisser tache
    $( ".draggable" ).draggable({
        revert:function(event) {

            if(!event.hasClass('yes')){
                return true;
            }
        }
    });


    $(".droppable").droppable({
        hoverClass: "z-depth-1",
        accept: ".draggable",
        drop: function(event,ui){

            var task = ui.draggable;
            var colonne = event.target;
            /*todo var position = task.position();var lastY = position.top;var lastX = position.left;*/
            task.removeAttr('style');
            task.appendTo(colonne);
        }
    });


    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            hover: true,
            belowOrigin: true
        }
    );

});
