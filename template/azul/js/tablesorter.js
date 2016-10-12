$(document).ready(function(){
	
    
    // CONSULTA NA TABELA 
    
    
    $('input#buscaDadosExecutados').quicksearch('table#tableServicosExecutados tr');
    /*$('input#buscaDadosExecutados').quicksearch({
    	labelText: 'Search: ',
        attached: '#tableOne',
        position: 'before',
        delay: 100,
        loaderText: 'Loading...',
        onAfter: function() {
            if ($("#tableOne tbody tr:visible").length != 0) {
                $("#tableOne").trigger("update");
                $("#tableOne").trigger("appendCache");
                $("#tableOne tfoot tr").hide();
            }
            else {
                $("#tableOne tfoot tr").show();
            }
        }
    });*/
    
    $('input#buscaDadosValidados').quicksearch('table#tableServicosValidados tr');
    
    $('input#buscaDadosAdmin').quicksearch('table#tableServicosAdmin tr');
    
    $('input#buscaCidade').quicksearch('table#tableListaCidades tr');
	
});