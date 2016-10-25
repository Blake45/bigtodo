$(document).ready(function(){

    $('select').material_select();

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
            task.removeAttr('style');
            task.appendTo(colonne);

            var url = url_changement_etat.replace('0',task.data('id')).replace('id_etat',$(colonne).data('etat'));
            tacheIsDoing(url);
        }
    });

    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            hover: true,
            belowOrigin: true
    });

    $('#tempsPrevu').clockpicker({
        afterDone: function() {
            var duration = $('#tempsPrevu').val();
            var regex = /[0-9]*:[0-9]*/;
            var value = 0;

            if(regex.test(duration)){
                duration = duration.split(':');
                value = parseInt(duration[0])*3600+parseInt(duration[1])*60;
            }else{
                throw Error("The value must match HH::mm");
            }

            $('#todobundle_tache_tempsPrevu').val(value);
        }
    });

    $(".button-collapse").sideNav();

});
