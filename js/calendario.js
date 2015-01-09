$(function(){
$("#calendario").datepicker({
dateFormat: 'dd/mm/yy',
dayNames: [
'Domingo','Segunda','Ter&ccedil;a','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'
],
dayNamesMin: [
'D','S','T','Q','Q','S','S','D'
],
dayNamesShort: [
'Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'
],
monthNames: [
'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',
'Outubro','Novembro','Dezembro'
],
monthNamesShort: [
'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
'Out','Nov','Dez'
],
nextText: 'Pr&oacute;ximo',
prevText: 'Anterior'

});
});


$(function(){
$("#calendario2").datepicker({
dateFormat: 'dd/mm/yy',
dayNames: [
'Domingo','Segunda','Ter&ccedil;a','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'
],
dayNamesMin: [
'D','S','T','Q','Q','S','S','D'
],
dayNamesShort: [
'Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'
],
monthNames: [
'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',
'Outubro','Novembro','Dezembro'
],
monthNamesShort: [
'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
'Out','Nov','Dez'
],
nextText: 'Pr&oacute;ximo',
prevText: 'Anterior'

});
});



$(function(){
$("#calendario3").datepicker({
dateFormat: 'dd/mm/yy',
dayNames: [
'Domingo','Segunda','Ter&ccedil;a','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'
],
dayNamesMin: [
'D','S','T','Q','Q','S','S','D'
],
dayNamesShort: [
'Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'
],
monthNames: [
'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',
'Outubro','Novembro','Dezembro'
],
monthNamesShort: [
'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
'Out','Nov','Dez'
],
nextText: 'Pr&oacute;ximo',
prevText: 'Anterior'

});
});

$(function(){

	$(".datepicker").datepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: [
		'Domingo','Segunda','Ter&ccedil;a','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'
		],
		dayNamesMin: [
		'D','S','T','Q','Q','S','S','D'
		],
		dayNamesShort: [
		'Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'
		],
		monthNames: [
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',
		'Outubro','Novembro','Dezembro'
		],
		monthNamesShort: [
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
		'Out','Nov','Dez'
		],
		nextText: 'Pr&oacute;ximo',
		prevText: 'Anterior'

		});

});

$(function(){

	$(".validade-cartao").datepicker({
		 changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/yy',
        showButtonPanel: true,
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        },
		dayNames: [
		'Domingo','Segunda','Ter&ccedil;a','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'
		],
		dayNamesMin: [
		'D','S','T','Q','Q','S','S','D'
		],
		dayNamesShort: [
		'Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'
		],
		monthNames: [
		'Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro',
		'Outubro','Novembro','Dezembro'
		],
		monthNamesShort: [
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
		'Out','Nov','Dez'
		],
		nextText: 'Pr&oacute;ximo',
		prevText: 'Anterior',
		currentText: 'Mês Atual',
		closeText: 'OK'

		});

});
