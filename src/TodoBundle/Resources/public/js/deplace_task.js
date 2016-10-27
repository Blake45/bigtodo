var tacheAjax = function(url_colonne,url_terminer){

    $.ajax({
        url: url_colonne
    }).done(function(retour){

       if( retour.success && url_terminer ) {
           $.ajax({
               url: url_terminer
           });
       }

    });

};