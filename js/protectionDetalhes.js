/*************** CONTANTES DE VALORES ***************/

const VEICULO_MOTO = "moto";
const VEICULO_CARRO = "carro";

const TIPO_PLANO_NOVO = 1;
const TIPO_PLANO_MIGRACAO = 2;

const MOTO_300CC = "300cc";

const PRECO_ADICIONAL_GNV = 1290;
const PRECO_ADICIONAL_RASTREADOR = 15000;

$(window).load( function () {

	function formatReal( int )
	{
		var tmp = int+'';
		tmp = tmp.replace(/([0-9]{2})$/g, ",$1");

		if( tmp.length > 6 )
		tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
	 
	return tmp;
	}

	/**************** Funções *****************/
	
	function getHorariosAgendamento(data) {
		
		$("#horario-visita").html('<option value="">Carregando...</option>');
		
		$.getJSON('ajax/json/protectionAgendamento.php?data=' + data, function (dados) {

			$("#horario-visita").html('<option value="">Selecione um Horário</option>');

			$.each( dados, function(i, obj) {

				$("#horario-visita").append('<option value="' + obj + ':00">' + data + ' às ' + obj + '</option>');

			})

		});

		
	}

	/********* Eventos aplicados a todos os elementos para padroes de classes ***********/
	
	/*********** clearOnChange_ *********/

	/* clearOnChange_ + Nome ou Id do objeto = Limpa o conteúdo do objeto com esta classe quando ocorrer o evento Chande no objeto
	 * informado após "clearOnChange_" */

	$("body *").bind ( "change", function () {
		
		var fName_byId = $(this).attr("id");
		var fName_byName = $(this).attr("name");

			$(".clearOnChange_" + fName_byId).html("<option></option>");
			$(".clearOnChange_" + fName_byName).html("<option></option>");
		
	});

	
	/******* Eventos ********/

	$(".eventClick").bind ( "click", function () {

		var fName_byId = $(this).attr("id");
		var fName_byName = $(this).attr("name");
		
		var objFunctions = new clickFunctions(fName_byId, fName_byName);
		
		if ( typeof objFunctions[fName_byId] === 'function' ) {
			
			objFunctions[fName_byId](this);
			
		} else if ( typeof objFunctions[fName_byName] === 'function' ) {
			
			objFunctions[fName_byName](this);
		
		} else {
			
			alert('Função para o evento "Click" do objeto "' + fName_byId + ":" + fName_byName + '" não encontrada.');
			
		}

		function clickFunctions (id, name) {

			return {
				
				adicionalGnv: function(curObject) {
					
					informaTaxaAdesao();
					
				},
				
				adicionalRastreador: function (curObject) {

					var tipoVeiculo = $("#fipeVeiculo").val();
					var valorVeiculo = $("#fipeAno_modelo option:selected").attr('data-valor');
					
					if ( tipoVeiculo == VEICULO_MOTO ) {
						
						$(curObject).attr('checked', true);
						
					} else if ( tipoVeiculo == VEICULO_CARRO && valorVeiculo > 30000 ) {
					
						$(curObject).attr('checked', true);
					
					}
					
					informaTaxaAdesao();
				}
			}

		}
	});


	$(".eventChange").bind ( "change", function () {
		
		var fName_byId = $(this).attr("id");
		var fName_byName = $(this).attr("name");
		
		var objFunctions = new changeFunctions(fName_byId, fName_byName);
		
		if ( typeof objFunctions[fName_byId] === 'function' ) {
			
			objFunctions[fName_byId](this);
			
		} else if ( typeof objFunctions[fName_byName] === 'function' ) {
			
			objFunctions[fName_byName](this);
		
		} else {
			
			alert('Função para o evento "Change" do objeto "' + fName_byId + ":" + fName_byName + '" não encontrada.');
			
		}

		function changeFunctions (id, name) {
			
			return {
				
				agendamentoProtection: function(curObject) {
					
					getHorariosAgendamento($(curObject).val());
				}
				
			}
			
		}
		
	});


	
	/***** Fim Eventos *****/
});
