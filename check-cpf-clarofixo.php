<?

include "conexao.php";
include_once "global-functions.php";

$icpf = $_GET['c'];

$conCPF = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto = '3' && (cpf = '".$icpf."' || cpf = '".soNumero($icpf)."') ");
$CPF = mysql_fetch_array($conCPF);

if($_GET['c'] != $_GET['o'] && $_GET['c'] != ''){
if(!$CPF){ echo '<input id="cpfduplicado" type="hidden" value="nao" name="cpfduplicado"><b style="color:#00d505"></b>';} else {echo '<input id="cpfduplicado" type="hidden" value="duplicado" name="cpfduplicado"><b style="color:#DD0000;font-size:12px;">CPF EXISTENTE!</b>';}
}
?>

