var tacheAjax = function(url_colonne,url_terminer){

    $.ajax({
        url: url_colonne
    }).done(function(retour){
       if( retour.success == true && url_terminer ) {
           $.ajax({
               url: url_terminer
           });
       }

    });

};

var tacheSupprimer = function(url,tache){

    $.ajax({
        url: url
    }).done(function(retour){
        if(retour.success) {
            tache.remove();
        }
    });

};