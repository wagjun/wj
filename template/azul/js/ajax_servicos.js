$(document).ready(function(){

    // Ajax que carrega as informacoes dos servicos de coleta executados

    $("#dialog:ui-dialog" ).dialog( "destroy" );
    $('#servicosDetalhes').hide();
    $("a[id^='coleta_']").click(function(){

        var coleta           = $(this).siblings('input#ordemColeta').val();
        var id_representante = $(this).siblings('input#id_representante').val();

        $('#servicosDetalhes').load( '/parceiros/servicos/buscaColeta/' + coleta + '/' + id_representante);
        
        $('#servicosDetalhes').dialog({
            title: 'Detalhes da Coleta',
            height: 550,
            width: 550,
            modal: true
        });
    });

    // Ajax que carrega as informacoes dos servicos entrega executados

    $("#dialog:ui-dialog" ).dialog( "destroy" );
    $('#servicosDetalhes').hide();
    $("a[id^='entrega_']").click(function(){

        var entrega          = $(this).siblings('input#ordemColeta').val();
        var id_representante = $(this).siblings('input#id_representante').val();

        $('#servicosDetalhes').load( '/parceiros/servicos/buscaColeta/' + entrega + '/' + id_representante);
        
        $('#servicosDetalhes').dialog({
            title: 'Detalhes da Entrega',
            height: 550,
            width: 550,
            modal: true
        });
    });
    
    
     // Ajax que carrega as informacoes dos servicos de coleta validados

    $("#dialog:ui-dialog" ).dialog( "destroy" );
    $('#servicosDetalhesValidados').hide();
    $("a[id^='coleta_']").click(function() {

        var coleta          = $(this).siblings('input#ordemColeta').val();
        var id_representante = $(this).siblings('input#id_representante').val();
        
        $('#servicosDetalhesValidados').load('/parceiros/servicos/buscaColetaValidada/' + coleta + '/' + id_representante);
        
        $( "#servicosDetalhesValidados" ).dialog({
            title: 'Detalhes Cálculo Serviço Coleta',
            height: 600,
            width: 550,
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        
    });

    // Ajax que carrega as informacoes dos servicos entrega validados

    $("#dialog:ui-dialog" ).dialog( "destroy" );
    $('#servicosDetalhesValidados').hide();
    $("a[id^='entrega_']").click(function(){

        var entrega          = $(this).siblings('input#ordemColeta').val();
        var id_representante = $(this).siblings('input#id_representante').val();
        
        $('#servicosDetalhesValidados').load('/parceiros/servicos/buscaColetaValidada/' + entrega + '/' + id_representante);
        
        $( "#servicosDetalhesValidados" ).dialog({
            title: 'Detalhes Cálculo Serviço Entrega',
            height: 600,
            width: 550,
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
    
    
 // Ajax que carrega as informacoes dos servicos coleta dos Representantes para o Admin

    $("#dialog:ui-dialog" ).dialog( "destroy" );
    $('#servicosDetalhesAdmin').hide();
    $("a[id^='admin_coleta_']").click(function(){

        var entrega = $(this).children().children().val();
        var id_representante = $(this).children().children('#id_representante').val();
        
        $('#servicosDetalhesAdmin').load('/parceiros/servicos/buscaColetaValidada/' + entrega + '/' + id_representante);
        
        $( "#servicosDetalhesAdmin" ).dialog({
            title: 'Detalhes Cálculo Serviço Coleta',
            height: 600,
            width: 550,
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
    
    
    // Ajax que carrega as informacoes dos servicos entrega dos Representantes para o Admin

    $("#dialog:ui-dialog" ).dialog( "destroy" );
    $('#servicosDetalhesAdmin').hide();
    $("a[id^='admin_entrega_']").click(function(){

        var entrega = $(this).children().children().val();
        var id_representante = $(this).children().children('#id_representante').val();
        
        $('#servicosDetalhesAdmin').load('/parceiros/servicos/buscaColetaValidada/' + entrega + '/' + id_representante);
        
        $( "#servicosDetalhesAdmin" ).dialog({
            title: 'Detalhes Cálculo Serviço Entrega',  
            height: 600,
            width: 550,
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
    
    
 // Ajax que carrega as informacoes das coletas pesquisadas no Admin

    $("#dialog:ui-dialog" ).dialog( "destroy" );
    $('#detalhesPesquisaOc').hide();
    $("a[id^='pesquisar_']").click(function(){

        var ordem_coleta	 = $(this).children().children().val();
        
        $('#detalhesPesquisaOc').load('/parceiros/servicos/detalhes/' + ordem_coleta );
        
        $( "#detalhesPesquisaOc" ).dialog({
            height: 300,
            width: 550,
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
});