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

	function getHorariosAgendamento(data) {
		
		$("#horario-visita").html('<option value="">Carregando...</option>');
		
		$.getJSON('ajax/json/protectionAgendamento.php?data=' + data, function (dados) {

			$("#horario-visita").html('<option value="">Selecione um Horário</option>');

			$.each( dados, function(i, obj) {

				$("#horario-visita").append('<option value="' + obj + ':00">' + data + ' às ' + obj + '</option>');

			})

		});

		
	}

	/**************** Funções para cálculos de valores *****************/
	
	function atualizaValorMensalidade() {

		var valorMensalidade = 0;
		
		var tipoVeiculo = $("#fipeVeiculo").val();
		var valorVeiculo = $("#fipeAno_modelo option:selected").attr("data-valor");
		var motoCilindrada = $("#motoCilindrada").val();
		
		valorMensalidade = getValorMensalidade();
		
		if ( valorMensalidade != false ) {
		
			$("#valorMensalidade").html("R$ " + formatReal(valorMensalidade) );
			$("[name='valorMensalidade']").val(valorMensalidade);

		} else {

			if ( (tipoVeiculo != 0 && tipoVeiculo != '' && valorVeiculo != 0 && valorVeiculo != '') || ( tipoVeiculo == VEICULO_MOTO && motoCilindrada != "") ) {
				
				$("#valorMensalidade").html("<span style=\"font-size:10px; color:red\">Veículo não coberto pelo seguro da Protection.</span>");
				$("[name='valorMensalidade']").val("");
			
			} else {

				$("#valorMensalidade").html("<span style=\"font-size:10px; color:red\">Selecione Veiculo, Marca, Modelo, Ano e Cilindrada (Somente moto) para o cálculo da mensalidade.</span>");
				$("[name='valorMensalidade']").val("");

			}
			
		}
		
	}
	
	function carregaAdicionais() {
		
		var tipoVeiculo = $("#fipeVeiculo").val();
		
		if ( tipoVeiculo == VEICULO_MOTO ) {

			$("#iBoxAdicionalGnv").css('display', 'none');
			$("#iBoxAdicionalRastreador").css('display', 'inline-block');

			$("#adicionalGnv").attr('checked', false);
			$("#adicionalRastreador").attr('checked', true);
			
			var valorVeiculo = getValorMensalidade();
			
			informaTaxaAdesao();

		} else if ( tipoVeiculo == VEICULO_CARRO ) {

			$("#iBoxAdicionalGnv").css('display', 'inline-block');
			$("#iBoxAdicionalRastreador").css('display', 'inline-block');
			
			informaTaxaAdesao();

		}
		
	}
	function informaTaxaAdesao() {

		var taxaAdesao = 0;
		var tipoPlano = $("#tipoplano").val();

		if ( tipoPlano == TIPO_PLANO_NOVO ) {

			taxaAdesao = getValorAdesao(TIPO_PLANO_NOVO);

		} else if ( tipoPlano == TIPO_PLANO_MIGRACAO ) {

			taxaAdesao = getValorAdesao(TIPO_PLANO_MIGRACAO);

		} else {

			$("#txAdesao").html("");
			$("[name='txAdesao']").val("");

		}

		if ( taxaAdesao == false ) {
		
			$("#txAdesao").html("");
			$("[name='txAdesao']").val("");
		
		}else{
			
			$("#txAdesao").html("R$ " + formatReal(taxaAdesao) );
			$("[name='txAdesao']").val(taxaAdesao);
			
		}
		
	}
	
	function getCotaParticipacao(tipoVeiculo, valorVeiculo) {

	/******************************** Calcula a cota de participação **********************************
	* 
	* Regra:
	* 
	* Para todas motos independente do valor, e carros abaixo de R$20.000,00 a cota de participação
	* é de R$600,00. Para carros acima de R$20.000,00 o valor da cota é de 3% o valor do carro.
	* 
	* ********************************************************************************************** */
		var cotaParticipacao = 60000;
		
		if ( valorVeiculo > 20000 && tipoVeiculo == VEICULO_CARRO ) {

			var tempCota = (valorVeiculo*3)/100;
			var ct = tempCota.toFixed(2);

			var cotaParticipacao = ct.replace('.','');

		}
		
		return cotaParticipacao;
		
	}

	function getValorAdesao(tipoPlano, adicionais) {
		
		var valorAdesao = parseFloat(0);
		
		if ( tipoPlano == TIPO_PLANO_NOVO ) {
			
			valorAdesao = parseFloat(35000);
			
		} else if ( tipoPlano == TIPO_PLANO_MIGRACAO ) {

			var valorMensalidade = getValorMensalidade();
			
			if ( valorMensalidade !== false ) {
				
				valorAdesao = parseFloat(valorMensalidade);
				
			} else {

				return false;
			}

		} else {

			return false;
			
		}

		if ( $("#adicionalRastreador").is(":checked") ) {
					
			valorAdesao = valorAdesao + parseFloat(PRECO_ADICIONAL_RASTREADOR);
					
		}
				
		if ( $("#adicionalGnv").is(":checked") ) {
					
			valorAdesao = valorAdesao + PRECO_ADICIONAL_GNV;
					
		}

		valorAdesao = parseInt( valorAdesao.toString().replace(".", "" ) );
		
		return valorAdesao;
	}
	
	function getValorMensalidade() {

	/******************************** Calcula o valor da mensalidade do seguro **********************************/
		var valorMensalidade = 0;

		var tipoVeiculo = $("#fipeVeiculo").val();
		var valorVeiculo = $("#fipeAno_modelo option:selected").attr("data-valor");
		var motoCilindrada = $("#motoCilindrada").val();		

		switch(tipoVeiculo) {
			
			case VEICULO_CARRO:
				
				if ( valorVeiculo <= 12000 ) {
					
					valorMensalidade = 10950;
					
				} else if ( valorVeiculo > 12000 && valorVeiculo <= 20000 ) {
					
					valorMensalidade = 12950;
					
				} else if ( valorVeiculo > 20000 && valorVeiculo <= 30000 ) {
					
					valorMensalidade = 14950;
					
				} else if ( valorVeiculo > 30000 && valorVeiculo <= 40000 ) {
					
					valorMensalidade = 16950;
					
				} else if ( valorVeiculo > 40000 && valorVeiculo <= 50000 ) {
					
					valorMensalidade = 24950;
					
				} else if ( valorVeiculo > 50000 && valorVeiculo <= 60000 ) {
					
					valorMensalidade = 26950;
					
				} else if ( valorVeiculo > 60000 && valorVeiculo <= 70000 ) {
					
					valorMensalidade = 28950;
					
				} else {

					return false;
				}
				
				break;
			
			case VEICULO_MOTO:
				
				if ( motoCilindrada == MOTO_300CC ) {
					
					valorMensalidade = 18900;
				
				} else if ( valorVeiculo <= 7000 ) {
					
					valorMensalidade = 6880;
					
				} else if ( valorVeiculo > 7000 && valorVeiculo <= 14000 ) {
					
					valorMensalidade = 9170;
					
				} else if ( valorVeiculo > 14000 && valorVeiculo <= 20000 ) {
					
					valorMensalidade = 11460;
					
				}else{

					return false;
				
				}
			
				break;
				
			default:

				return false;

		}

		return valorMensalidade;
		
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
				},

				fipeVeiculo: function(curObject) {
					
					/********** Carrega as marcas para o tipo de veículo selecionado *********/
					
					carregaAdicionais();
					
					var tipoVeiculo = $(curObject).val();
					
					if ( tipoVeiculo == 0 || tipoVeiculo == "" ) {
						
					} else {
					
						$.getJSON('ajax/json/protectionFipe.php?action=marcas&tipo=' + tipoVeiculo, function (dados) {
							
							$("#fipeMarca").html('<option value="0">Selecione uma marca</option>');
							
							$.each( dados, function(i, obj) {
								
								$("#fipeMarca").append('<option value="' + obj.id + '">' + obj.nome + '</option>');
								
							})
							
						});
						
						if ( tipoVeiculo == VEICULO_MOTO ) {
						
							$(".lineCilindradas").css("display", "table-row");
						
						} else {
							
							$(".lineCilindradas").css("display", "none");
							$("#motoCilindrada").val('0');
							
						}
						
					}
					
				},

				fipeMarca: function(curObject) {
					
					/********* Carrega os modelos para o tipo de veículo e marca selecionados *********/
					
					var marcaVeiculo = $(curObject).val();
					
					if ( marcaVeiculo == 0 || marcaVeiculo == "" ) {
						
					} else {
					
						$.getJSON('ajax/json/protectionFipe.php?action=modelos&marca=' + marcaVeiculo, function (dados) {
							
							$("#fipeModelo").html('<option value="0">Selecione um Modelo</option>');
							
							$.each( dados, function(i, obj) {
								
								$("#fipeModelo").append('<option value="' + obj.id + '">' + obj.nome + '</option>');
								
							})
							
						});
					}

				},

				fipeModelo: function(curObject) {
					
					/********* Carrega os modelos para o tipo de veículo e marca selecionados *********/
					
					var modeloVeiculo = $(curObject).val();

					if ( modeloVeiculo == 0 || modeloVeiculo == "" ) {
						
					} else {
					
						$.getJSON('ajax/json/protectionFipe.php?action=anos&modelo=' + modeloVeiculo, function (dados) {
							
							$("#fipeAno_modelo").html('<option value="0">Selecione o ano e modelo</option>');
							
							$.each( dados, function(i, obj) {
								
								var valorVeiculo = obj.valor;
								var tipoVeiculo = $("#fipeVeiculo").val();

								var cotaParticipacao = getCotaParticipacao(tipoVeiculo, valorVeiculo);

								$("#fipeAno_modelo").append('<option value="' + obj.id + '" data-cota-participacao="' + cotaParticipacao  + '" data-valor="' + obj.valor + '">' + obj.nome + '</option>');
								
							})
							
						});
					}

				},

				fipeAno_modelo: function(curObject) {
					
					/********* Carrega e exibe os valores do carro e Cota de Participação para o veículo selecionado *********/
					
					if ( $(curObject).val() == 0 || $(curObject).val() == "" ) {
						
						$(".fipeVal").html('');
						$(".fipeCota").html('');

					} else {
					
						$(".lineFipeVal").css('display', 'table-row');
						$(".fipeVal").html('R$ ' + formatReal( $('option:selected', curObject).attr('data-valor') + "00" ) );
						$("[name='valorVeiculo']").val( $('option:selected', curObject).attr('data-valor') + "00" );

						$(".lineFipeCota").css('display', 'table-row');
						$(".fipeCota").html('R$ ' + formatReal( $('option:selected', curObject).attr('data-cota-participacao') ) );

					}
					
					atualizaValorMensalidade();
					informaTaxaAdesao();

				},

				motoCilindrada: function(curObject) {

					informaTaxaAdesao();

					atualizaValorMensalidade();
				},
				
				tipoplano: function(curObject) {
					
					var tipoPlano = $(curObject).val();

					informaTaxaAdesao();

					atualizaValorMensalidade();
				}
			}
			
		}
		
	});


	
	/***** Fim Eventos *****/
});
