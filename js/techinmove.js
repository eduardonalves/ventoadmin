
$(function(){
	
			/*************** Mascaras e suas validacões ***************/
		
		var maskFuncs = 
						{
							aplicaMascara : function (obj, validar=false, init=false) {
								
								var functionName = $(obj).attr('data-masktype') ? $(obj).attr('data-masktype') : $(obj).attr('name');
			
								if( typeof maskFuncs[functionName] === 'function' ){
									
									return maskFuncs[functionName]( $(obj).val(), validar, init );

								}
								
							},

							cartao : function (v, validar=false, init=false){
									
									if(init) { return v; }
									
									if( ! validar ){

										//Remove tudo o que não é dígito
										v=v.replace(/\D/g,"");
										//Coloca parênteses em volta dos dois primeiros dígitos

										v=v.replace(/^(\d{4})(\d)/g,"$1-$2");
										//Coloca hífen entre o quarto e o quinto dígitos

										v=v.replace(/(\d{4})(\d)/,"$1-$2");
										v=v.replace(/(\d{4})(\d)/,"$1-$2");

										return v;
									
									} else if (validar){
										
										var patt = new RegExp("^[0-9]{4}-+[0-9]{4}-+[0-9]{4}-+[0-9]{4}");
										return patt.test(v);

									}
							},

							cnpj : function (v, validar=false){

									if( ! validar ){
										//Remove tudo o que não é dí­gito
										v=v.replace(/\D/g,"");

										//Coloca parênteses em volta dos dois primeiros dí­gitos
										v=v.replace(/^(\d{2})(\d)/g,"$1.$2");

										//Coloca hífen entre o quarto e o quinto dígitos
										v=v.replace(/(\d{3})(\d)/,"$1.$2");

										//retorne o resultado
										v=v.replace(/(\d{3})(\d)/,"$1/$2");

										//retorne o resultado
										v=v.replace(/(\d{4})(\d)/,"$1-$2");

										return v;
									
									} else if (validar){
										
										var patt = new RegExp("^[0-9].+[0-9]{3}.+[0-9]{3}/+[0-9]{4}-+[0-9]{2}");
										return patt.test(v);

									}
							},
							
							cep: function (v, validar=false){

								if( !validar){
									//Remove tudo o que não é dígito

									v=v.replace(/\D/g,"");

									//Coloca hífen entre o quarto e o quinto dígitos

									v=v.replace(/(\d{5})(\d)/,"$1-$2");

									//retorne o resultado

									return v;
								
								} else if (validar){
									
										var patt = new RegExp("^[0-9]{5}-+[0-9]{3}");
										return patt.test(v);
										
								}

							},
							
							telefone: function (v, validar=false){
								
								if( !validar){

									//Remove tudo o que não é dígito
									v=v.replace(/\D/g,"");
									
									//Coloca parênteses em volta dos dois primeiros dí­gitos
									v=v.replace(/^(\d\d)(\d)/g,"($1) $2");

									if( v.length < 14 ){
									
										//Coloca hífen entre o quarto e o quinto dí­gitos
										v=v.replace(/(\d{4})(\d)/,"$1-$2");

									} else {

										//Coloca hífen entre o quarto e o quinto dí­gitos
										v=v.replace(/(\d{1})(\d{4})(\d)/,"$1-$2-$3");

									}

									//retorne o resultado
									return v;
								
								} else if (validar){


									if( v.length <= 14 ){

										var patt = new RegExp("^[(]+[0-9]{2}[) ]+[0-9]{4}-[0-9]{4}");
										
									} else {
										
										var patt = new RegExp("^[(]+[0-9]{2}[) ]+[0-9]{1}-[0-9]{4}-[0-9]{4}");
										
									}
									

									return patt.test(v);

								}

							},
							
							moeda : function (v, validar=false){
								
										if(! validar){

											//Remove tudo o que não é dígito
											v=v.replace(/\D/g,"");

											var numLen = v.length-2;
											var dots = Math.ceil(numLen/3);
											
											if(dots>=2){
												
												var valor = v.substr(0, v.length-2);
												var pattern = "";
												var pattern2 = "";
												
												for (i=1; i <= dots; i++) {
													
													pattern += i==1 ? "([0-9]{1,3})" : "([0-9]{3})";
													
													pattern2 += i==dots ? "$" + i : "$" + i + ".";
												}
												
												pattern += "$";
			
												var re = new RegExp(pattern, 'g');
												
												valor = valor.replace(re, pattern2);

												v = valor + "," + v.substr(-2);
											
											} else {

												if ( (v.length == 2 || v.length == 3) && parseInt(v)==0 ){
													
													v = "";
													
												}else{

													v = v.replace(/^(0)(\d{3,})$/, "$2");
													v = v.replace(/([0-9]{0,4})([0-9]{2})$/g, "$1,$2");
													v = v.replace(/^(,?)(\d{1,2})$/, "0,$2");
												}

											}

											return v!='' ? "R$ " + v : "" ;
										
										} else {
											
											//var patt = new RegExp("^R$ [0-9]{1,3}.?[0-9]{3}*,[0-9]{2}$");
											//alert(patt.test(v));
											return true;
										}
							}
						}		
    
		
		
		
		/**************** Fim Mascaras e suas validacões ***************/
		
		/***************  Funcoes de Classes  ***************/
		
		var infoCampoObrigatorio = $('<span />', {
											
											'class' : 'campoobrigatorio',
											text: '*'
											}
										);
		
		$( function() {

			infoCampoObrigatorio.insertAfter('.campo-obrigatorio');
			
			$(window).load( function(){
				
			
				$('.mask').each( function(){
				
					$(this).val(maskFuncs['aplicaMascara'](this, false, true));

				});
			
			});

		});
		
		function validarCampo(obj) {
			
			var objValue;
			
			if($(obj).is(':disabled'))
			{
				return true;
			}

			
			if( $(obj).is('SELECT') ) {
				
				objValue = $(obj, '[option:selected]').val();
				
				if( objValue  == "" ) {

					return false;

				}


			} else if ( $(obj).is('TEXTAREA') )  {

				objValue = $(obj).val();

				if( objValue == "" ) {

					return false;

				}

					
			} else {

				objValue = $(obj).val();

				if( objValue == "" ) {

					return false;

				}

			}

			if ( $(obj).hasClass('mask') ){

				maskFuncs['aplicaMascara'](obj, true);
				
			}
			
			return true;
			
		}
		
		$(document).on('keyup', '.mask', function(){

			$(this).val(maskFuncs['aplicaMascara'](this));
			
		});
		
		$(document).on('focusout', '.campo-invalido', function(event) {

			if( validarCampo(this) ) {

				$(this).removeClass('campo-invalido');

			}
			
		});
		
		$('.bt-submit-form').click( function() {
			
			var form = $("[name='" + $(this).attr('data-formulario') + "']");

			$('.campo-obrigatorio').each( function() {
				
				if($(this).css('display')!='none'){

					if (! validarCampo(this) ) {
						
						$(this).addClass('campo-invalido');
						
						
					}

				}
				
			});
			

			if( $('.campo-invalido').length == 0 ){

				$(form).submit();
				return true;
				
			} else {

				$('html, body').animate({
				
					scrollTop: $(".campo-invalido").offset().top -95
				
				}, 800);
				
				$(".campo-invalido")[0].focus();
				
				alert("Os campos marcados em vermelho são obrigatórios. Preencha-os corretamente.");
				
				return false;
			}

			
		});
		/*
		$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : "/examples/upload",
		
		chunk_size : '1mb',
		rename : true,
		dragdrop: true,
		
		filters : {
			// Maximum file size
			max_file_size : '10mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Image files", extensions : "jpg,gif,png"},
				{title : "Zip files", extensions : "zip"}
			]
		},

		// Resize images on clientside if we can
		resize: {
			width : 200, 
			height : 200, 
			quality : 90,
			crop: true // crop to exact dimensions
		},


		// Flash settings
		flash_swf_url : '/plupload/js/Moxie.swf',
	
		// Silverlight settings
		silverlight_xap_url : '/plupload/js/Moxie.xap'
	});
	* */
});
