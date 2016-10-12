$(document).ready(function() {
    
    $('input[type=text]').keyup(function(){
        $(this).val().toUpperCase();
    });
    
    // IMPLEMENTA MASCARA MONETARIA NO MÓDULO DE NEGOCIACAÇÃO DOS REPRESENTANTES
    $('input[id*=valor]').priceFormat({
        limit: 7,
        centsLimit: 2,
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
    // IMPLEMENTA MASCARA MONETARIA NAS TELAS DE SERVICOS
    $('input[id=declarado]').priceFormat({
        limit: 11,
        centsLimit: 2,
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
    // MASCARAS DE HORARIO

    $('.hora').mask('99:99');

    // TESTES COM AJAX
    $('input[type=button]').click(function(){
        $('#ajax').load('/parceiros/testes/viewAjax');
    });

    $('#imprimeFechados').click(function(){

        $('#relatorioServicosFechados').printElement();
    });

    $('#imprimeAbertos').click(function(){
    
        $('#relatorioServicosAbertos').printElement();
    });
    
    $('#imprimeExecutados').click(function(){
        
        $('#relatorioServicosExecutados').printElement();
    });
    
    $('#imprimePagar').click(function(){
        
        $('#relatorioServicosPagar').printElement();
    });

    
    $('#listaCidadesAssociadas').hide();
    
    $('#exibeCidadesVinculadas').click(function(){
       
        $('#listaCidadesAssociadas').show('slow');
    });
    
    $('#escondeCidadesVinculadas').click(function(){
       
        $('#listaCidadesAssociadas').hide('slow');
    });
    
    
    
    
    
    $('#botaoServicosFechados').click(function(){

        var inicio = $('#inicio').val();
        var fim    = $('#fim').val();

        if (inicio == null || inicio == '' || fim == null || fim == '') {

            $('#msgPeriodo').html('<p style="color: red;">Campos Obrigatórios</p>');
            return false;
        } 
    });
    
    $('#botaoServicosAbertos').click(function(){

        var inicio = $('#inicio').val();
        var fim    = $('#fim').val();

        if (inicio == null || inicio == '' || fim == null || fim == '') {

            $('#msgPeriodo').html('<p style="color: red;">Campos Obrigatórios</p>');
            return false;
        } 
    });
    
    $('#botaoServicosPagar').click(function(){

        var inicio = $('#inicio').val();
        var fim    = $('#fim').val();

        if (inicio == null || inicio == '' || fim == null || fim == '') {

            $('#msgPeriodo').html('<script type="text/javascript"> alert("Periodo nao pode ser nulo!")</script>');
            return false;
        } 
    });
    
    
    
    $('#servicosFiltrosAvancados').hide();
    $('#filtrosAplicados').text('Filtro padrão: Últimos 30 dias e Pendentes');
    $('#exibirFiltrosAvancados').text('Filtros: ').click(function(){
        
        if ($('#exibirFiltrosAvancados').text() == 'Filtros: ') {
            
            $('#filtrosAplicados').text('');
            $('#exibirFiltrosAvancados').text('Esconder Filtros: ');
        } else {
            
            $('#filtrosAplicados').text('');
            $('#exibirFiltrosAvancados').text('Filtros: ');
        }
        
        $('#servicosFiltrosAvancados').toggle();
    });
    
    
    $('#botaoEnviaGeracaoFaturamento').click(function(){
       
       $.messager.confirm('Gerar Faturamento', 'Confirma Geração de faturamento?', function(r){  
           
           if (r){ $('#formularioFechamentoServicos').submit(); }  
       });
    });
    
});