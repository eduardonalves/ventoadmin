<?php

include_once "lib/class.MetasNet.php";

$metasNet = new metasNet($conexao);

?>
<style>

.metas-area{
	
	width:90%;
	
	text-align:left;
	
}

.meta-item{
	margin-left:10px;
	
	display:inline-block;
	position:relative;
	width:230px;
	
	margin-bottom:20px;
	
	border: 1px solid #E5E5E5;
}
.meta-desc{
	

	text-align:center;
	
	background-color:#E5E5E5;
	
	margin-top:-25px;
	
	width:100%;
	height:40px;
	
	overflow:hidden;
	
	line-height:40px;
	
	font-size:12px;
	

}

.meta-name{
	
	background-color:#007BA4;
	
	text-align:center;
	font-weight:bold;
	
	color: #FFFFFF;
	
	padding:10px;
	
}

.box-metabar{
	
	height:200px;
	
	overflow:hidden;
	
}
.meta-bar{
	position:absolute;
	
	min-height:30px;
	max-height:165px;
	width:230px;
	height:90%;
	/* background-color:#90EE90; */
	background-color:#00BBEE;
	
	text-align:center;
	font-weight:bold;
	color: #1E90FF;
	border-bottom:5px #FFFFFF solid;
	bottom:40px;


}

.porcentagem{
	
	margin-top:10px;
	color:#FFFFFF;
}
</style>
<?php

	function getHeightValue($porc){
		
		return ($porc * 165)/100;
		
	}

?>

<br><br><br>

<div class="metas-area">

	<div class="meta-item">
		
	<?php
	
	$metaND = $metasNet->getMetaND($ano.$mes);
	$barH = getHeightValue($metaND['porcentagem']);

	?>
		
		<div class="meta-name">
		
			Meta ND
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important;">
				
					<div class="porcentagem"><?php echo $metaND['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php
			if ($metaND['porcentagem'] < 100 && $metaND !== false){
				
				echo "Meta: " . $metaND['meta'] . " (Faltam " . ($metaND['meta'] - $metaND['atingida']) . " vendas.)";

			}elseif ($metaND === NULL || $metaND === false){
				
				echo "NÃO CADASTRADA";
				

			}else{
				
				echo "Meta batida";
				
			}
			?>
		</div>

	</div>

	<div class="meta-item">

	<?php
	
	$metaEmpresa = $metasNet->getMetaEmpresa($ano.$mes);
	$barH = getHeightValue($metaEmpresa['porcentagem']);

	?>
		
		<div class="meta-name">
		
			Meta Empresa
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important;">
				
					<div class="porcentagem"><?php echo $metaEmpresa['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php
			if ($metaEmpresa['porcentagem'] < 100 && $metaEmpresa !== false){
				
				echo "Meta: " . $metaEmpresa['meta'] . " (Faltam " . ($metaEmpresa['meta'] - $metaEmpresa['atingida']) . " vendas.)";
				
			}elseif ($metaEmpresa === NULL || $metaEmpresa === false ){
				
				echo "NÃO CADASTRADA";
			
			}else{
				
				echo "Meta batida";
				
			}
			?>
			
		</div>

	</div>

	<div class="meta-item">

	<?php
	
	$metaCelular = $metasNet->getBonusCelular($ano.$mes);
	$barH = getHeightValue($metaCelular['porcentagem']);

	?>

		<div class="meta-name">
		
			Bônus Celular
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important;">
				
					<div class="porcentagem"><?php echo $metaCelular['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php
			if ($metaCelular['porcentagem'] < 100 && $metaCelular !== false ){
				
				echo "Meta: " . $metaCelular['meta'] . " (Faltam " . ($metaCelular['meta'] - $metaCelular['atingida']) . " vendas.)";

			}elseif ($metaCelular === NULL || $metaCelular === false){
				
				echo "NÃO CADASTRADA";
				
			}else{
				
				echo "Meta batida";
				
			}
			?>

			
		</div>

	</div>

	<div class="meta-item">

	<?php
	
	$metaCombinada = $metasNet->getMetaPersonalizada($ano.$mes, 'combinada');
	$barH = getHeightValue($metaCombinada['porcentagem']);
	
	?>
		
		<div class="meta-name">
		
			Combinado
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important;">
				
					<div class="porcentagem"><?php echo $metaCombinada['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php
			
			if ($metaCombinada['batida']){
				
				echo "META BATIDA";

			}elseif ($metaCombinada['porcentagem'] == ""){
				
				echo "NÃO CADASTRADA";
				
			}else{
				
				echo "META A SER BATIDA";
			}
			?>
			
		</div>

	</div>

	<div class="meta-item">

	<?php
	
	$metaEspecial1 = $metasNet->getMetaPersonalizada($ano.$mes, 'especial1');
	$barH = getHeightValue($metaEspecial1['porcentagem']);

	?>
		
		<div class="meta-name">
		
			Especial 1
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important;">
				
					<div class="porcentagem"><?php echo $metaEspecial1['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php
			
			if ($metaEspecial1['batida']){
				
				echo "META BATIDA";

			}elseif ($metaEspecial1['porcentagem'] === NULL || $metaEspecial1 === false){
				
				echo "NÃO CADASTRADA";
				
			}else{
				
				echo "META A SER BATIDA";
			}
			?>
			
		</div>

	</div>

	<div class="meta-item">

	<?php
	
	$metaEspecial2 = $metasNet->getMetaPersonalizada($ano.$mes, 'especial2');
	$barH = getHeightValue($metaEspecial2['porcentagem']);

	?>
		
		<div class="meta-name">
		
			Especial 2
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important;">
				
					<div class="porcentagem"><?php echo $metaEspecial2['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php
			
			if ($metaEspecial2['batida']){
				
				echo "META BATIDA";

			}elseif ($metaEspecial2['porcentagem'] === NULL || $metaEspecial2 === false){
				
				echo "NÃO CADASTRADA";
			
			}else{
				
				echo "META A SER BATIDA";
			}
			?>
			
		</div>

	</div>

	<div class="meta-item">

	<?php
	
	$metaEspecial3 = $metasNet->getMetaPersonalizada($ano.$mes, 'especial3');
	$barH = getHeightValue($metaEspecial3['porcentagem']);

	?>
		
		<div class="meta-name">
		
			Especial 3
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important;">
				
					<div class="porcentagem"><?php echo $metaEspecial3['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php
			
			if ($metaEspecial3['batida']){
				
				echo "META BATIDA";

			}elseif ($metaEspecial3['porcentagem'] === NULL || $metaEspecial3 === false){
				
				echo "NÃO CADASTRADA";
				
			}else{
				
				echo "META A SER BATIDA";
			}
			?>
			
		</div>

	</div>

	<div class="meta-item">

	<?php
	
	$metaChurn120 = $metasNet->getChurn120($ano.$mes);
	$barH = getHeightValue($metaChurn120['porcentagem']);

	?>

		<div class="meta-name">
		
			Churn 120
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important; background-color:<?php echo $metaChurn120['cor']; ?> !important">
				
					<div class="porcentagem"><?php echo $metaChurn120['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php

			if($metaChurn120['porcentagem'] <= 2.95){
				
				echo "BONUS! Dentro da meta < 2.95";
				
			}elseif ($metaChurn120['porcentagem'] > 2.95 && $metaChurn120['porcentagem'] <= 4.65){
				
				echo "Dentro da meta > 2.95 < 4.65";
				
			}else{
				
				echo "DESCONTADO! Fora da meta.";
			}
			?>

			
		</div>

	</div>

	<div class="meta-item">

	<?php
	
	$metaBonuNd = $metasNet->getBonusVolumeNd($ano.$mes);
	$barH = getHeightValue($metaBonuNd['porcentagem']);

	?>

		<div class="meta-name">
		
			Bônus Volume ND
			
		</div>
		
		<div class="box-metabar">

			<div class="meta-bar" style="height:<?php echo round($barH); ?>px !important; background-color:<?php echo $metaBonuNd['cor']; ?> !important">
				
					<div class="porcentagem"><?php echo $metaBonuNd['porcentagem']; ?>%</div>
				
			</div>

		</div>
		
		<div class="meta-desc">
			
			<?php
			if ($metaBonuNd['atingida'] <= 100) {
				
				echo "SEM BÔNUS";

			} elseif($metaBonuNd['atingida'] > 100 && $metaBonuNd['atingida'] <= 250) {
				
				echo "BÔNUS INTERMEDIARIO";

			}else{

				echo "BÔNUS ESPECIAL";
			}
			?>

			
		</div>

	</div>

</div>


