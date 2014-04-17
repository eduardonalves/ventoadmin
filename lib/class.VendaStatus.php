<?php

class VendaStatus extends VentoAdmin{

	private $Venda;
	public $produtoId;
	
	private $statusLabels = array (

								1 => array (
								
									'PRE-ANALISE' => 'Pré-Análise',
									'ANÁLISE' => 'Análise',
									'RESTRIÇÃO' => 'Restrição',
									'APROVADO' => 'Aprovado',
									'INSTALAR' => 'Instalar',
									'CONECTADO' => 'Conectado',
									'CANCELADO' => 'Cancelado',
									'DEVOLVIDO' => 'Devolvido',
									'ESTORNADA' => 'Estornada',
									'AGUARDANDO PAGAMENTO' => 'Aguardando Pagamento'
								),
							
								3 => array(
								
									'PRE-ANALISE' => 'Pré-Análise',
									'RESTRIÇÃO' => 'Restrição',
									'REDIRECIONADO' => 'Redirecionado',
									'SEM COBERTURA' => 'Sem Cobertura',
									'GRAVAR' => 'Gravar',
									'GRAVADO' => 'Gravado',
									'ENTREGAR' => 'Entregar',
									'BOLETO GERADO' => 'Boleto Gerado',
									'SEM CONTATO' => 'Sem Contato',
									'DEVOLVIDO' => 'Devolvido',
									'PENDENTE' => 'Pendente',
									'ENVIAR GRAVAÇÃO' => 'Enviar Gravação',
									'RECUPERADO' => 'Recuperado',
									'CANCELADO' => 'Cancelado',
									'FINALIZADA' => 'Finalizada'
									
								
								)
	
							);

	private $fluxo =  array (
	
							1 => array (
							
								'PRE-ANALISE' => array(),
								'ANÁLISE' => array(),
								'RESTRIÇÃO' => array(),
								'APROVADO' => array(),
								'INSTALAR' => array(),
								'CONECTADO' => array(),
								'CANCELADO' => array(),
								'DEVOLVIDO' => array(),
								'ESTORNADA' => array(),
								'AGUARDANDO PAGAMENTO' => array()
							),
						
							3 => array (

								'PRE-ANALISE' => array('REDIRECIONADO','RESTRIÇÃO','SEM COBERTURA','GRAVAR','DEVOLVIDO','SEM CONTATO'),
								'RESTRIÇÃO' => array(),
								'REDIRECIONADO' => array(),
								'SEM COBERTURA' => array(),
								'GRAVAR' => array('GRAVADO', 'SEM CONTATO', 'DEVOLVIDO'),
								'GRAVADO' => array('PENDENTE', 'ENVIAR GRAVAÇÃO','DEVOLVIDO'),
								'ENTREGAR' => array('ENVIAR GRAVAÇÃO','DEVOLVIDO'),
								'BOLETO GERADO' => array('ENVIAR GRAVAÇÃO','DEVOLVIDO'),
								'SEM CONTATO' => array('CANCELADO', 'GRAVAR'),
								'DEVOLVIDO' => array('CANCELADO', 'GRAVAR'),
								'PENDENTE' => array('GRAVADO'),
								'ENVIAR GRAVAÇÃO' => array('FINALIZADA'),
								'RECUPERADO' => array(),
								'CANCELADO' => array(),
								'FINALIZADA' => array()
							)
					
						);
						
	private $fluxoExcept = array (
								
								3 => array (

									'PRE-ANALISE' => array (
													
													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'RESTRIÇÃO' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
													
									),

									'REDIRECIONADO' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'userMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array('CANCELADO','RECUPERADO')

													)
									),
									
									'SEM COBERTURA' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array('RECUPERADO')

													)
									),
									
									'GRAVAR' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),
									
									'GRAVADO' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													),

													'vendaExterna' => array(
																
																'==' => array (
																	
																		'Venda.tipoVenda' => array('EXTERNA'),
																		),
																'flux' => array('RESTRIÇÃO','ENVIAR GRAVAÇÃO', 'DEVOLVIDO')

													),

													'tipoEmbratelBoleto' => array(
																
																'==' => array (
																	
																		'Venda.tipoEntrega' => array('EMBRATEL'),
																		'Venda.pagamento' => array('BOLETO')
																		),
																'flux' => array('BOLETO GERADO', 'DEVOLVIDO', 'RESTRIÇÃO')

													),

													'tipoEmbratelCartao' => array(
																
																'==' => array (
																	
																		'Venda.tipoEntrega' => array('EMBRATEL'),
																		'Venda.pagamento' => array('CARTÃO DE CRÉDITO')
																		),
																'flux' => array('PENDENTE', 'DEVOLVIDO', 'RESTRIÇÃO','ENVIAR GRAVAÇÃO')

													)


									),
									
									'ENTREGAR' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),
									
									'BOLETO GERADO' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),
									
									'SEM CONTATO' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'userMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													),

													'userMonitorInterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR')
																		),
																'flux' => array('CANCELADO')

													)

									),
									
									'DEVOLVIDO' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'userMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array('CANCELADO','RECUPERADO')

													),

													'userMonitorOuSupervisor' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR', 'SUPERVISOR')
																		),
																'flux' => array('CANCELADO','RECUPERADO')

													)
									),
									
									'PENDENTE' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'userMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array('CANCELADO','RECUPERADO')

													),

													'tipoEmbratelCartao' => array(
																
																'==' => array (
																	
																		'Venda.tipoEntrega' => array('EMBRATEL'),
																		'Venda.pagamento' => array('CARTÃO DE CRÉDITO')
																		),
																'flux' => array('GRAVADO', 'RESTRIÇÃO')

													)
									),
									
									'ENVIAR GRAVAÇÃO' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													),

													'vendaExterna' => array(
																
																'==' => array (
																	
																		'Venda.tipoVenda' => array('EXTERNA'),
																		),
																'flux' => array('FINALIZADA')

													)
									),
									
									'CANCELADO' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),
									
									'FINALIZADA' => array (

													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE','RESTRIÇÃO','REDIRECIONADO','SEM COBERTURA','GRAVAR','GRAVADO','ENTREGAR','BOLETO GERADO','SEM CONTATO','DEVOLVIDO','PENDENTE','ENVIAR GRAVAÇÃO','CANCELADO','FINALIZADA')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									)
			
								)
	
							);


	function __construct(Venda &$venda){
		
		parent::__construct();
		
		$this->Venda =& $venda;

		$this->produtoId = (int) $this->Venda->produto;

	}
	
	private function validaExcept($except)
	{
		
		$validate = true;
		
		foreach( $except as $key=>$value )
		{

			if ( $key != 'flux' ) 
			{
				
				if ( $key == '==' && $validate === true)
				{
					
					foreach( $value as $chave=>$valor )
					{
						
						
						
						foreach($valor as $val)
						{
						$valid = false;
						
						$parseObj = explode(".", $chave);
						
						if ( strtolower($this->$parseObj[0]->$parseObj[1]) == strtolower($val) ) { $valid = true; }
						
						}
						
						if ($validate === true) { $validate = $valid; }
						
					}
					

				}

				if ( $key == '!=' && $validate === true )
				{
					foreach( $value as $chave=>$valor )
					{
						
						
						
						foreach($valor as $val)
						{
						$valid = false;
						
						$parseObj = explode(".", $chave);
						
						if ( strtolower($this->$parseObj[0]->$parseObj[1]) != strtolower($val) ) { $valid = true; }
						
						}
						
						if ($validate === true) { $validate = $valid; }
						
					}
				}

				if ( $key == '>' && $validate === true )
				{
					foreach( $value as $chave=>$valor )
					{
						
						
						
						foreach($valor as $val)
						{
						$valid = false;
						
						$parseObj = explode(".", $chave);
						
						if ( strtolower($this->$parseObj[0]->$parseObj[1]) > strtolower($val) ) { $valid = true; }
						
						}
						
						if ($validate === true) { $validate = $valid; }
						
					}

				}

				if ( $key == '<' && $validate === true )
				{
					foreach( $value as $chave=>$valor )
					{
						
						
						
						foreach($valor as $val)
						{
						$valid = false;
						
						$parseObj = explode(".", $chave);
						
						echo strtolower($this->$parseObj[0]->$parseObj[1]) ." < ".strtolower($val), "<br>";
						if ( strtolower($this->$parseObj[0]->$parseObj[1]) < strtolower($val) ) { $valid = true; }
						
						}
						
						if ($validate === true) { $validate = $valid; }
						
					}

				}
				
			}
			
		}
		
		return $validate;
		
	}
	
	public function getFluxo($status=''){
		
		if($status=='') { $status = $this->Venda->status; }
		
		$status = strtoupper($status);
		
		if( array_key_exists($status, $this->fluxoExcept[$this->produtoId]) )
		{
			
			foreach($this->fluxoExcept[$this->produtoId][$status] as $except)
			{
				
				if( $this->validaExcept($except) )
				{
					
					$fluxo = $except['flux'];

					$fluxoReturn = array();

					foreach( $fluxo as $fluxoId )
					{
						$fluxoReturn[$fluxoId] = $this->getStatusLabel($fluxoId);
					}
					
					asort($fluxoReturn);

					$fluxoReturn = array($this->Venda->status =>$this->getStatusLabel($this->Venda->status) ) + $fluxoReturn;
		
					return $fluxoReturn;
					
				}
				
			}
			
		}
		
		if( array_key_exists($status, $this->fluxo[$this->produtoId]) )
		{

			$fluxo = array();
			
			$fluxo = $this->fluxo[$this->produtoId][$status];

			$fluxoReturn = array();
		
			foreach( $fluxo as $fluxoId )
			{
				$fluxoReturn[$fluxoId] = $this->getStatusLabel($fluxoId);
			}
			
			asort($fluxoReturn);
			
			$fluxoReturn = array($this->Venda->status =>$this->getStatusLabel($this->Venda->status) ) + $fluxoReturn;

			return $fluxoReturn;
		
		}else{

			if( array_key_exists($status, $this->statusLabels[$this->produtoId]) )
			{
				
				$fluxo = array($this->Venda->status);
				
				foreach( $fluxo as $fluxoId )
				{
					$fluxoReturn[$fluxoId] = $this->getStatusLabel($fluxoId);
				}
				
				asort($fluxoReturn);
	
				return $fluxoReturn;
			
			}else{
				
				trigger_error("Este status não pertence ao fluxo desta venda: " . $status, E_USER_ERROR);
				return false;
			}
			
		}
		
	}
	
	public function getStatusLabel($status='')
	{

		if($status=='') { $status = $this->Venda->status; }
		
		$status = strtoupper($status);
		
		if( array_key_exists($status, $this->statusLabels[$this->produtoId]) )
		{
			
			$label = $this->statusLabels[$this->produtoId][$status];
			
			return $label;
		
		}else{
			
			trigger_error("Label de status não encontrado: " . $status, E_USER_ERROR);
			return false;
		}

		
	}
	
	public function getAllStatus()
	{
		$allStatus = $this->statusLabels[$this->produtoId];
		
		asort($allStatus);

		return $allStatus;
	}
	
}

?>
