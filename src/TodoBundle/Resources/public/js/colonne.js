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
            var url_over = "";
            if( $(colonne).data('etat') == "finis" ){
                url_over = url_tache_terminer.replace('0',task.data('id'));
            }
            tacheAjax(url,url_over);

        }
    });

    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            hover: true,
            belowOrigin: true
    });

    /*$('#tempsPrevu').clockpicker({
        afterDone: function() {
            var duration = $('#tempsPrevu').val();
            var regex = /[0-9]*:[0-9]*!/;
            var value = 0;

            if(regex.test(duration)){
                duration = duration.split(':');
                value = parseInt(duration[0])*3600+parseInt(duration[1])*60;
            }else{
                throw Error("The value must match HH::mm");
            }

            $('#todobundle_tache_tempsPrevu').val(value);
        }
    });*/

    $('select.time').change(function(){

        var days = $('#jours').val();
        var hours = $('#heures').val();
        var minutes = $('#minutes').val();
        value = parseInt(days*25200)+parseInt(hours*3600)+parseInt(minutes*60);
        $('#todobundle_tache_tempsPrevu').val(value);
    });

    $(".button-collapse").sideNav();
    $('#alert .fa-close').click(function(){
        $(this).parent().remove();
    });

    $('.card-action .fa-close').click(function(){
        var url_suppression = url_tache_suppression.replace('0',$(this).parent().parent().parent().data('id'));
        tacheAjax(url_suppression);
        $(this).parent().remove();
    });

});
