<? include "../conexao.php"; 

session_start();
// Verificar se est� logado

if(!isset($_SESSION['usuario'])){ ?>

	
<script type="text/javascript">

window.location = '../index.php'

</script>	

<? } 
$conUSUARIO = $conexao->query("SELECT * FROM usuarios WHERE id = '".$_SESSION['usuario']."'");
$USUARIO = mysql_fetch_assoc($conUSUARIO);


$num = $_POST['id'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>OS CLARO TV</title>

<style type="text/css">

body{ font-family:Arial, Helvetica, sans-serif; margin:1px 1px 1px 1px;}

.txt0{ font-size:18px; font-weight:bold;}

.txt2{ font-size:12px;}

.os{ position:relative; height:1385px;}

.table0{ border: 1px; }

.table1{ border: 1px; }

.table1 tr{ height:26px;}

</style>

</head>

<body>

<?

foreach($num as $id){
	
$consultaVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE id = '".$id."'");	
$VENDA = mysql_fetch_array($consultaVENDA);


$nome = strtoupper($VENDA['nome']);
$cpf = $VENDA['cpf'];

if($VENDA['lote']) { $lote = ' - Lote:'.$VENDA['lote'];}
if($VENDA['quadra']) { $quadra = ' - Qd: '.$VENDA['quadra'];}

if($VENDA['complemento']) { $complemento = ' - Complemento: '.$VENDA['complemento'];}

$endereco = $VENDA['endereco'].', '.$VENDA['numero'].' '.$lote.$quadra.$complemento;
$bairro = $VENDA['bairro'];
$cidade = $VENDA['cidade'];
$uf = $VENDA['uf'];
$cep = $VENDA['cep'];

$telefone1 = $VENDA['telefone'];
$telefone2 = $VENDA['telefone2'];
$telefone3 = $VENDA['telefone3'];

$referencia = $VENDA['ponto_referencia'];
$emissao = date("d/m/Y");

$proposta = $VENDA['proposta'];
$contrato = $VENDA['contrato'];
$produto = $VENDA['plano'];
$pontos = $VENDA['pontos'];

$taxaInstalacao = $VENDA['valor'];



?>
<div class="os">
<table border="1" width="950" cellpadding="0" cellspacing="0" class="table0">
<!-- Linha 1 -->
<tr>
<td align="center" width="160" style="font-size:9px">
<img src="img/embratel.jpg" width="150" />
<br />
Embratel tvsat telecomunica��es s/a <br />
CNPJ:09.132.659/0001-76
</td>

<td>
	<!-- Informa��es Topo Centro -->
	<table border="0" width="100%">
		<tr>
			<td colspan="3">Cliente: <?= $nome; ?></td>
		</tr>
		<tr>
			<td colspan="3">CPF/CNPJ: <?= $cpf; ?></td>
		</tr>
		<tr>
			<td colspan="3">Endere�o: <?= $endereco; ?> - <?= $bairro; ?> - <?= $cidade; ?> - <?= $uf; ?> &nbsp; CEP: <?= $cep; ?></td>
		</tr>
		<tr>
			<td>Tel Res: <?= $telefone1; ?></td>
			<td>Tel Celular: <?= $telefone2; ?></td>
			<td>Tel Comercial: <?= $telefone3; ?></td>
		</tr>

		<tr>
			<td colspan="3">Refer�ncia: <?= $VENDA['ponto_referencia']; ?></td>
		</tr>
		<tr>
			<td colspan="2">Solicita��o:</td>
			<td>Emiss&atilde;o: <?= $emissao; ?></td>
		</tr>
		<tr>
			<td colspan="3">Node:</td>
		</tr>
		<tr>
			<td colspan="3">Equipe:</td>
		</tr>
		<tr>
			<td colspan="3">Parceiro: C01342_P_RJ_VENTO</td>
		</tr>
	</table>
    <!-- Fim Informa��es Topo Centro -->
</td>

<td align="center" width="160" style="font-size:9px">
<img src="img/claro.jpg" width="150" /><br />
Claro TV<br />
Servi�o de TV por assinatura<br />
www.claro.com.br/clarotv<br />
</td>
</tr>
<!-- Fim Linha 1 -->

<!-- Linha 2 -->
<tr class="txt2">
<td colspan="3">
	<table border="0" width="100%">
		<tr>
			<td>Proposta: <?= $proposta;?></td>
			<td width="370px">Portabilidade:</td>
		</tr>
	</table>
</td>
</tr>
<!-- Fim Linha 2 -->


<!-- Linha 3 -->
<tr class="txt2">
<td colspan="3">
	<table border="0" width="100%">
		<tr>
			<td width="25%">Contrato: <?= $contrato?></td>
			<td width="25%">Produto: <?= $produto;?></td>
            <td width="25%">Qtde. de Pontos: <?= $pontos;?></td>
            <td width="25%">Data de Habilita��o: <?= $emissao;?></td>
		</tr>
	</table>
</td>
</tr>
<!-- Fim Linha 3 -->

<!-- Linha 4 -->
<tr class="txt2">
<td colspan="3">
	<table border="0" width="100%">
		<tr>
			<td width="12%">Nr. S�rie:</td>
			<td width="20%">Taxa de Instala��o: R$ <?= $taxaInstalacao;?></td>
            <td width="16%">Localiza��o: </td>
            <td width="16%">Tipo/Modelo: </td>
            <td width="16%">Instala��o: </td>
            <td width="16%">Pol�tica Equip:</td>
		</tr>
	</table>
</td>
</tr>
<!-- Fim Linha 4 -->


<!-- Linha 5 -->
<tr class="txt2">
<td colspan="3">
	<table border="0" class="table1" width="100%">
		<tr>
			<td width="15%">Data:</td>
			<td width="25%">Servi�o Executado:</td>
            <td width="20%">Equipe: </td>
            <td width="20%">Parceiro: </td>
            <td width="20%">C�d. Baixa: </td>
		</tr>
	</table>
</td>
</tr>
<!-- Fim Linha 5 -->

<!-- Linha 6 -->
<tr class="txt2">
<td colspan="2">
	<table border="0" width="100%">
		<tr>
			<td width="25%">OS:</td>
			<td width="25%">Tipo de OS:</td>
            <td width="25%">Produto: </td>
            <td width="25%">Tipo Equip: </td>
		</tr>
	</table>
</td>
<td align="center" class="txt0">SD<br /><br /></td>
</tr>
<!-- Fim Linha 6 -->

<!-- Linha 7 -->

<tr align="center">
<td colspan="3" class="txt0">
MATERIAIS UTILIZADOS / RETIRADOS
</td>
</tr>

<!-- Fim Linha 7 -->

<!-- Linha 8 -->
<tr class="txt2">
<td colspan="3">
	<table border="1" width="100%" cellpadding="0"  class="table1" cellspacing="0">
		<tr align="center" class="trtable1">
			<td width="8%">C�DIGO</td>
			<td width="">MATERIAIS DTH</td>
            <td width="5%">QTDE</td>
            <td width="8%">C�DIGO</td>
            <td width="">MATERIAIS HPC</td>
            <td width="5%">QTDE</td>
            <td width="8%">C�DIGO</td>
            <td width="">MATERIAIS</td>
            <td width="5%">QTDE</td>
		</tr>
        
        <tr class="trtable1">
			<td>70075212</td>
			<td>Antena Offset de 60cm</td>
            <td>1</td>
            <td>70084526</td>
            <td>Conector F Selado (outdoor)</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>        
        
        <tr class="trtable1">
			<td>70075213</td>
			<td>Antena Offset de 90cm</td>
            <td></td>
            <td>70084554</td>
            <td>Fita pl�stica diel�trica</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>

        <tr class="trtable1">
			<td>70084888</td>
			<td>Antena UHF LOG PROC 470-890MHZ</td>
            <td></td>
            <td>70084567</td>
            <td>Fecho para fita pl�stica diel�trica</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>        

        <tr class="trtable1">
			<td>70075215</td>
			<td>LNBF Simples</td>
            <td><? if($pontos == 0){ echo '1'; }?></td>
            <td>70084553</td>
            <td>Gancho span clamp U</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>
        
        <tr class="trtable1">
			<td>70075217</td>
			<td>LNBF Duplo</td>
            <td><? if($pontos == 1){ echo '1'; }?></td>
            <td>70084522</td>
            <td>Cabo RG-6Tn-shield preto com mensageiro</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>
        
        <tr class="trtable1">
			<td>70084119</td>
			<td>LNBF Banda KU Qu�druplo Universal</td>
            <td></td>
            <td>70084568</td>
            <td>Pit�o com flangee bucha S10</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>
        
        <tr class="trtable1">
			<td>70075208</td>
			<td>Kit Fixa��o</td>
            <td>1</td>
            <td>70084579</td>
            <td>Bucha para passagem coaxial</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>
        
        <tr class="trtable1">
			<td>70075209</td>
			<td>Kit Instala��o</td>
            <td>1</td>
            <td>70084527</td>
            <td>Emenda F</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>
        
        <tr class="trtable1">
			<td>70075622</td>
			<td>Conector Tipo F Hexagonal</td>
            <td></td>
            <td>70084523</td>
            <td>Cabo RG-6Tn-shield branco sem mensageiro</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>
        
        <tr class="trtable1">
			<td>70084525</td>
			<td>Conector Tipo F Compress�o</td>
            <td>1</td>
            <td>70084525</td>
            <td>Conector F (indoor) Compress�o</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>
        
        <tr class="trtable1">
			<td>70075417</td>
			<td>Diplexer VHF/UHF - SAT</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>                                                            

	</table>
</td>
</tr>
<!-- Fim Linha 8 -->

<!-- Linha 9 -->

<tr align="center">
<td colspan="3" class="txt2">
	<table border="1" class="table1" cellpadding="0" cellspacing="0" width="100%">
		<tr align="center">
			<td colspan="12">Nr. S�rie</td>
			<td width="8%">Localiza��o</td>
            <td width="8%">Instalado</td>
            <td width="8%">Retirado</td>
            <td colspan="2" width="8%">N�veis DTH</td>
            <td colspan="4" width="20%">N�veis HFC</td>
		</tr>
        
        <tr align="center">
			<td width="120px" align="left">DEC</td>
            <td></td>
            <td></td>
			<td></td>
            <td></td>
            <td></td>
			<td></td>
            <td></td>
            <td></td>  
			<td></td>
            <td></td>
            <td></td>                       
			
            <td>Sala</td>
            <td>SIM</td>
            <td>N�O</td>
            
            <td>QS</td>
            <td>NS</td>
            
            <td>MER</td>
            <td>BER</td>
            <td>C.ALTO</td>
            <td>C.Baixo</td>
		</tr>
        
        <tr>
			<td>SC</td>
            <td></td>
            <td></td>
			<td></td>
            <td></td>
            <td></td>
			<td></td>
            <td></td>
            <td></td>  
			<td></td>
            <td></td>
            <td></td>                       
			
            <td></td>
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>
        
        <tr>
			<td>DEC</td>
            <td></td>
            <td></td>
			<td></td>
            <td></td>
            <td></td>
			<td></td>
            <td></td>
            <td></td>  
			<td></td>
            <td></td>
            <td></td>                       
			
            <td></td>
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>      
        
        <tr>
			<td>SC</td>
            <td></td>
            <td></td>
			<td></td>
            <td></td>
            <td></td>
			<td></td>
            <td></td>
            <td></td>  
			<td></td>
            <td></td>
            <td></td>                       
			
            <td></td>
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>  
        
        <tr>
            <td colspan="3">M.Terrestre</td>
            <td colspan="2"></td>  
			<td colspan="2"></td>
            <td colspan="2"></td>
            <td colspan="2"></td>                       
			
            <td></td>
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>   
        
        <tr>
            <td colspan="3">Chave SMU</td>
            <td colspan="2"></td>  
			<td colspan="2"></td>
            <td colspan="2"></td>
            <td colspan="2"></td>                       
			
            <td></td>
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr> 
        
        <tr>
            <td colspan="4">Certid�o de Nascimento</td>
            <td colspan="2"></td>  
			<td colspan="2"></td>
            <td></td>
            <td></td>
            <td></td>                       
			
            <td></td>
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
		</tr>                              
	</table>
</td>
</tr>

<!-- Fim Linha 9 -->

<!-- Linha 10 -->

<tr>
<td colspan="3" class="txt2">
	<table border="1" class="table1" cellpadding="0" cellspacing="0" width="100%">
    	<tr>
        	<td width="25%">Executado pela Equipe:</td>
            <td width="25%">Hora de Entrada:</td>
            <td width="25%">Hora de Sa�da:</td>
            <td width="25%">C�d.Baixa:</td>
        </tr>
    </table>
</td>
</tr>


<!-- Fim Linha 10 -->


<!-- Linha 11 -->

<tr>
<td colspan="3" class="txt2">
	<table border="1" class="table1" cellpadding="0" cellspacing="0" width="100%">
    	<tr>
        	<td>
            	Documentos entregues: 
                ( ) Conta de telefone   
                ( ) �gua/Luz/G�s   
                ( ) Extrato Banc�rio   
                ( ) Capa carn� IPTU  
                ( ) Fatura Cart�o de Cr�dito	
             </td>
        </tr>
    </table>
</td>
</tr>

<!-- Fim Linha 11 -->


<!-- Linha 12 -->

<tr>
<td colspan="3" class="txt2">
	<table border="1" class="table1" cellpadding="0" cellspacing="0" width="100%">
    	<tr>
        	<td>
				( ) Instala��o Casa    
                ( ) Instala��o Pr�dio    
                ( ) Sacada    
                ( ) Cobertura Pr�dio   
                ( ) Chave SMU	
             </td>
        </tr>
    </table>
</td>
</tr>

<!-- Fim Linha 12 -->


<!-- Linha 13 -->

<tr>
<td colspan="3" class="txt0">
	<table border="1" class="table0" cellpadding="0" cellspacing="0" width="100%">
    	<tr align="center" bgcolor="#CCCCCC" height="30px">
        	<td>IMPORTANTE LEIA: LEIA ATENTAMENTE ANTES DE ASSINAR </td>
        </tr>
    </table>
</td>
</tr>

<!-- Fim Linha 13 -->



</table>
<!-- /////////////// FIM TABLE BODY //////////// -->

<!-- Linha 14 -->

	<table border="0" class="table1" cellpadding="0" cellspacing="0" width="950px">
    	<tr style="font-size:9px; color:#333">
        	<td><br />
				Ao assinar este documento, declaro estar ciente:
1) Que o SERVI�O contratado ser� prestado com base nos termos e condi��es do CONTRATO DE PRESTA��O DO SERVI�O DE TV POR ASSINATURA VIA SAT�LITE. 2) De ter recebido c�pia do contrato o qual li e concordo com os termos e
condi��es nesse mencionado; 3) Do direito previsto no Artigo 49 do C�digo de Defesa do Consumidor; 4) Que a desconex�o do servi�o n�o me isenta da quita��o de d�bitos pendentes relativos aos servi�os prestados at� a data de solicita��o nem ao
pagamento em virtude de quebra de fidelidade, ficando a Embratel -TV Sat, autorizada nesses casos a cobrar o valor corrigido do benef�cio utilizado; 5) Que as visitas t�cnicas ser�o cobradas conforme condi��es estabelecidas no contrato; 6) Que os
equipamentos instalados e cedidos em modelo de comodato est�o sob minha responsabilidade, devendo devolve-los no momento de rescis�o em condi��es perfeitas. Caso seja detectado pelos t�cnicos avarias ou adultera��es, haver� cobran�a a t�tulo
de reposi��o dos equipamentos.<br />
<b><u>Para os clientes que optaram pela promo��o com renova��o de benef�cio e fidelidade:</u></b> Estou ciente que adquiri uma promo��o na mensalidade Claro TV por um per�odo determinado renov�vel automaticamente pelo mesmo per�odo contratado,
assumindo uma renova��o do prazo de fidelidade com a Claro TV por mais 12 meses, contados a partir da data de renova��o do novo per�odo de desconto promocional. Estou ciente que para a n�o renova��o do per�odo promocional, bem como do
per�odo de fidelidade, o titular da assinatura Claro TV dever� entrar em contato com o SAC Claro TV solicitando o encerramento da promo��o em at� no m�ximo 10 dias �teis ap�s o primeiro per�odo de desconto recebidos na contrata��o do servi�o.<br />
                OBS: <br /><br />
             </td>
        </tr>
    </table>

<!-- Fim Linha 14 -->


<!-- Linha 15 -->

	<table border="1" class="table1" cellpadding="5" cellspacing="0" width="950px">
    	<tr class="txt2">
        	<td>
				T�cnico ensinou a usar o sistema: (x) SIM   ( ) N�O <br />
				Qualidade dos canais abertos antes da visita:  ( ) BOM  (x) RUIM <br />
				Sistema Claro TV funcionando em perfeitas condi��es, testado com o cliente (x) SIM     ( ) N�O <br />
				Houve danos no im�vel ou equipamento ( ) SIM     (x) N�O <br />
             </td>
             <td width="150px">
             Avalia��o do servi�o
t�cnico realizado:
(P�ssimo) 0 � 10 (�timo) 
                  10
             </td>
             <td>
             	Indique um amigo <br />
				Nome: _____________________   <br />                                     
				Telefone:(  ) _____________                                
             </td>
             
        </tr>
    </table>

<!-- Fim Linha 15 -->


<br /><br />
<!-- Linha 16 -->

	<table border="0" class="table1" cellpadding="0" cellspacing="0" width="950px">        
        <tr class="txt2" align="center">
			<td><hr size="1" /> <span style="font-weight:bold">Assinatura da Equipe T�cnica</span>  </td>
			<td><u><?= $emissao; ?></u> <br /> <span style="font-weight:bold">Data</span></td>
			<td><u><?= $nome;?></u> <br /> <span style="font-weight:bold">Nome do Cliente</span>  </td>
			<td><u><?= $cpf;?></u> <br /> <span style="font-weight:bold">CPF/ CNPJ</span></td>
			<td><hr size="1" /> <span style="font-weight:bold">Assinatura do Cliente</span></td>
        </tr>
    </table>

<!-- Fim Linha 16 -->


</div>
<? } ?>

<script type="text/javascript" src="../js/jquery.js"></script>


<script type="text/javascript">

$(document).ready(function(e) {
	
	$("img").fadeIn(1000, function(){
		
		window.print();
        setTimeout("window.close();", 0000); 
		
		
		});
  

    
});



</script>

</body>
</html>