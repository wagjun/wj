/*  Função utilizada na associação de cidades aos Representantes */
function lookup(inputString) {
    if(inputString.length == 0) {
        // Hide the suggestion box.
        $('#suggestions').hide();
    } else {
        $.post("/parceiros/representantescidades/cidadesAjaxLista", { queryString: ""+inputString+"" }, function(data) {
            
        	if(data.length > 0) {
                $('#suggestions').show();
                $('#autoSuggestionsList').html(data);
            }
        });
    }
} // lookup

function fill(thisValue, id) {
    $('#inputString').val(thisValue); // nome da cidade
    $('#hidden').val(id);             // id da cidade
    setTimeout("$('#suggestions').hide();", 200);
}
/* Fim das funções de associação */

//==============================================================================

$(document).ready(function() {
    
    // IMPLEMENTAÇÃO FEITA PARA O FUNCIONAMENTO DO BREADCRUMBS

    var url       = window.location;
    var urlString = url.toString();
    var urlArray  = urlString.split("/");

    var controlador = 4;//urlArray.length - 2;
    var metodo      = 5;//urlArray.length - 1;

    $('#breadcrumbs').load('/parceiros/modulos/breadcrumbs/' + urlArray[controlador] + '/' + urlArray[metodo]);

// ============================================================================================================== //
    
    
    
    
    // AJAX SELECIONA REPRESENTANTE PARA ATRIBUIÇÃO DE VALORES ÀS TAXAS
    $('#selecionaRepresentante').change(function(){

        var id_representante = this.value;

        $('#msg').html('');
        $('#listaNegociacao').html("<img style='margin-left: 450px; margin-top: 100px;' src='/parceiros/application/images/carregando1.gif' />");
        setTimeout(function(){
            $('#listaNegociacao').load('/parceiros/negociacao/listar/' + id_representante)
        }, 0);
    });

    // AJAX SELECIONA REPRESENTANTE PARA ASSOCIAÇÃO DE CIDADES AO REPRESENTANTE
    $('#selecionaParceiro').change(function(){ 

        var rep = this.value;

        $('#msg').html('');
        $('#listaCidades').html("<img style='margin-left: 450px; margin-top: 100px;' src='/parceiros/application/images/carregando1.gif' />");
        setTimeout(function(){
            $('#listaCidades').load('/parceiros/representantescidades/cidades/' + rep)
        }, 0);
    });

    // AJAX SELECIONA PERIODO NA TELA DE USUARIO DO REPRESENTANTE PARA LISTAGEM DOS SERVIÇOS EXECUTADOS
    $('#selecionaPeriodo').click(function(){

        var inicio          = $('#inicio').val();
        var fim             = $('#fim').val();
        var coleta          = $('#checkColetas').is(':checked');
        var entrega         = $('#checkEntregas').is(':checked');
        var preenchidos     = $('#checkPreenchidos').is(':checked');
        var naoPreenchidos  = $('#checkNaoPreenchidos').is(':checked');

        if ( inicio == null || inicio == '' || fim == null || fim == '' ) {

            alert('Informe o Período');
        } else {

            $('#listaPeriodo').html("<img style='margin-left: 450px; margin-top: 100px;' src='/parceiros/application/images/carregando1.gif' />");
                setTimeout(function(){
                    $('#listaPeriodo').load('/parceiros/servicos/comissoes/' + fim + '/' + inicio + '/' + coleta + '/' + entrega + '/' + preenchidos + '/' + naoPreenchidos );
            }, 0);
        }
    });
    
    // AJAX SELECIONA PERIODO NA TELA DE USUARIO DO REPRESENTANTE PARA LISTAGEM DOS SERVIÇOS VALIDADOS
    $('#selecionaPeriodoValidados').click(function(){

        var inicio          = $('#inicio').val();
        var fim             = $('#fim').val();
        var coleta          = $('#checkColetas').is(':checked');
        var entrega         = $('#checkEntregas').is(':checked');
        var validados       = $('#checkValidados').is(':checked');
        var naoValidados    = $('#checkNaoValidados').is(':checked');

        if ( inicio == null || inicio == '' || fim == null || fim == '' ) {

            alert('Informe o Período');
        } else {

            $('#listaValidados').html("<img style='margin-left: 450px; margin-top: 100px;' src='/parceiros/application/images/carregando1.gif' />");
                setTimeout(function(){
                    $('#listaValidados').load('/parceiros/servicos/homologacao/' + fim + '/' + inicio + '/' + coleta + '/' + entrega + '/' + validados + '/' + naoValidados );
            }, 0);
        }
    });
    
    // AJAX COMBOS DEPENDENTES TESTES

    $('#estadoAjax').change(function(){
        var estado = this.value;
        if (estado == 0){
            $('#cidadeAjax').html('<option value=0>SELECIONE</option>');
        } else {
            $('#cidadeAjax').html('<option>Carregando...</option>');
            setTimeout(function(){
                $("#cidadeAjax").load("/parceiros/testes/cidade/" + estado , 1000);
            });
        }
    });


    $('#dialogAjaxView').click(function(){
    $('#carregaDialog').html("<img style='margin-left: 450px; margin-top: 100px;' src='/parceiros/application/images/carregando1.gif' />");
        setTimeout(function(){
            $('#carregaDialog').load('/parceiros/testes/dialog/'); }  , 500 ); 
        
    });


    // Ajax que lista os serviços prestados pelos Representantes

    $('#selecionaPeriodoServico').click(function(){

        var inicio 	   = $('#inicio').val();
        var fim            = $('#fim').val();
        var rep            = $('#representante').val();
        var coleta         = $('#checkColetas').is(':checked');
        var entrega 	   = $('#checkEntregas').is(':checked');
        var preenchidos    = $('#checkPreenchidos').is(':checked');
        var naoPreenchidos = $('#checkNaoPreenchidos').is(':checked');
        var validados 	   = $('#checkValidados').is(':checked');
        var naoValidados   = $('#checkNaoValidados').is(':checked');

        if (inicio == null || inicio == '' || fim == null || fim == '') {

            alert('Período não pode ser nulo!');
        } else {

            $('#listaServicosPrestados').html("<img style='margin-left: 450px; margin-top: 100px;' src='/parceiros/application/images/carregando1.gif' />");
            setTimeout(function(){
                $('#listaServicosPrestados').load('/parceiros/servicos/coletas_entregas/' + fim + '/' + inicio + '/' + rep + '/' + coleta + '/' +  entrega + '/' + preenchidos + '/' +  naoPreenchidos + '/' +  validados + '/' + naoValidados );
            }, 0);

        }
    });
    
    
    // AJAX PESQUISA ORDEM DE COLETA NO REPRESENTANTE E NO PEGASUS 
    
    $('#botaoPesquisaOc').click(function(){

        var ordem_coleta = $('#ordem_coleta').val();

        $('#resultadoPesquisaOc').html("<img style='margin-left: 450px; margin-top: 100px;' src='/parceiros/application/images/carregando1.gif' />");
        setTimeout(function(){
            $('#resultadoPesquisaOc').load('/parceiros/servicos/encontrar/' + ordem_coleta);
        }, 0);
    });
    
    // AJAX UTILIZADO NOS REPAROS DE INFORMA�OES DAS COLETAS DO M�DULO PESQUISAR ORDENS DE COLETAS
    
    $('select#parceiro_origem').change(function(){
    	
    	var id_representante = this.value;
    	
    	$('select#cidade_origem').html("<option value=0>Carregando...</option>");
        setTimeout(function(){
        	$('select#cidade_origem').load('/parceiros/representantescidades/cidadesRepresentantes/' + id_representante );
        }, 0);
    });
    
    $('select#parceiro_destino').change(function(){
    	
    	var id_representante = this.value;
    	
    	$('select#cidade_destino').html("<option value=0>Carregando...</option>");
        setTimeout(function(){
        	$('select#cidade_destino').load('/parceiros/representantescidades/cidadesRepresentantes/' + id_representante );
        }, 0);
    });
    
    
    
    
});