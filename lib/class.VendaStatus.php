<?php

class VendaStatus extends VentoAdmin{

	private $Venda;
	public $produtoId;
	
	private $statusLabels = array (

								1 => array (
									'PRE-ANALISE' => 'Pré-Análise',
									'ANÁLISE' => 'Análise',
									'GRAVAR' => 'Gravar',
									'APROVADO' => 'Aprovado',
									'DEVOLVIDO' => 'Devolvido',
									'SEM CONTATO' => 'Sem Contato',
									'RESTRIÇÃO' => 'Restrição',
									'INSTALAR' => 'Instalar',
									'CANCELADO' => 'Cancelado',
									'RECUPERADO' => 'Recuperado',
									'CONECTADO' => 'Conectado'
								),
								
								2 => array(
									
									'PRE-ANALISE' => 'Pŕe-Análise',
									'DEVOLVIDO' => 'Devolvido',
									'RESTRIÇÃO' => 'Restrição',
									'GRAVAR' => 'Gravar',
									'GRAVADO' => 'Gravado',
									'SEM CONTATO' => 'Sem Contato',
									'RECUPERADO' => 'Recuperado',
									'CANCELADO' => 'Cancelado',
									'AUTORIZADA' => 'Autorizada',
									//'PÓS VENDAS' => 'Pós Vendas',
									'ATIVADO' => 'Ativado',
									'ENTREGAR' => 'Entregar'

								),
								
								3 => array(
								
									'BLOQUEADA' => 'Bloqueada',
									'PRE-ANALISE' => 'Pré-Análise',
									'CONSULTA' => 'Consulta',
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
									
								
								),

								7 => array(
									'AGENDADO' => 'Agendado',
									'VISTORIAR' => 'Vistoriar',
									'INSERIR DOCUMENTOS' => 'Inserir Documentos',
									'CANCELADO' => 'Cancelado',
									'FINALIZADA' => 'Finalizada'
									
								
								),

								9 => array (
									'PRE-ANALISE' => 'Pré-Análise',
									'ANÁLISE' => 'Análise',
									'GRAVAR' => 'Gravar',
									'APROVADO' => 'Aprovado',
									'DEVOLVIDO' => 'Devolvido',
									'SEM CONTATO' => 'Sem Contato',
									'RESTRIÇÃO' => 'Restrição',
									'INSTALAR' => 'Instalar',
									'CANCELADO' => 'Cancelado',
									'RECUPERADO' => 'Recuperado',
									'CONECTADO' => 'Conectado',
									'SEM COBERTURA' => 'Sem Cobertura'
								),

								10 => array (
									'PRE-ANALISE' => 'Pré-Análise',
									'ANÁLISE' => 'Análise',
									'GRAVAR' => 'Gravar',
									'APROVADO' => 'Aprovado',
									'DEVOLVIDO' => 'Devolvido',
									'SEM CONTATO' => 'Sem Contato',
									'RESTRIÇÃO' => 'Restrição',
									'INSTALAR' => 'Instalar',
									'CANCELADO' => 'Cancelado',
									'RECUPERADO' => 'Recuperado',
									'CONECTADO' => 'Conectado',
									'SEM COBERTURA' => 'Sem Cobertura'
								)

							);

	private $fluxo =  array (

							1 => array (
							
									'PRE-ANALISE' => array('RESTRIÇÃO','GRAVAR','DEVOLVIDO'),
									'ANÁLISE' => array('APROVADO','RESTRIÇÃO'),
									'GRAVAR' => array('APROVADO','SEM CONTATO','DEVOLVIDO'),
									'APROVADO' => array('ANÁLISE','INSTALAR'),
									'DEVOLVIDO' => array('CANCELADO','RECUPERADO'),
									'SEM CONTATO' => array('CANCELADO','RECUPERADO'),
									'RESTRIÇÃO' => array(),
									'INSTALAR' => array('CANCELADO','CONECTADO'),
									'CANCELADO' => array(),
									'RECUPERADO' => array(),
									'CONECTADO' => array()
							),
							
							2 => array(
									
								'PRE-ANALISE' => array('DEVOLVIDO','GRAVAR','RESTRIÇÃO'),
								'DEVOLVIDO' => array('RECUPERADO','CANCELADO'),
								'RESTRIÇÃO' => array(),
								'GRAVAR' => array('DEVOLVIDO','SEM CONTATO','GRAVADO','RESTRIÇÃO'),
								'GRAVADO' => array('RESTRIÇÃO','AUTORIZADA'),
								'ENTREGAR' => array('AUTORIZADA'),
								'SEM CONTATO' => array('CANCELADO','RECUPERADO'),
								'RECUPERADO' => array(),
								'CANCELADO' => array(),
								'AUTORIZADA' => array('ATIVADO'),
								//'PÓS VENDAS' => array('ATIVADO'),
								'ATIVADO' => array()

							),
						
							3 => array (

								'PRE-ANALISE' => array('REDIRECIONADO','RESTRIÇÃO','SEM COBERTURA','GRAVAR','DEVOLVIDO','SEM CONTATO'),
								'CONSULTA' => array('GRAVAR','CANCELADO'),
								'RESTRIÇÃO' => array(),
								'REDIRECIONADO' => array(),
								'SEM COBERTURA' => array(),
								'GRAVAR' => array('GRAVADO', 'SEM CONTATO', 'DEVOLVIDO'),
								'GRAVADO' => array('PENDENTE', 'ENVIAR GRAVAÇÃO','DEVOLVIDO'),
								'ENTREGAR' => array('ENVIAR GRAVAÇÃO','DEVOLVIDO'),
								'BOLETO GERADO' => array('ENVIAR GRAVAÇÃO','DEVOLVIDO'),
								'SEM CONTATO' => array('CANCELADO', 'GRAVAR'),
								'DEVOLVIDO' => array('CANCELADO', 'RECUPERADO'),
								'PENDENTE' => array('GRAVADO'),
								'ENVIAR GRAVAÇÃO' => array('FINALIZADA'),
								'RECUPERADO' => array(),
								'CANCELADO' => array(),
								'FINALIZADA' => array(),
								'BLOQUEADA' => array()
							),

							7 => array(

								'AGENDADO' => array('VISTORIAR', 'CANCELADO'),
								'VISTORIAR' => array('INSERIR DOCUMENTOS'),
								'INSERIR DOCUMENTOS' => array('FINALIZADA'),
								'CANCELADO' => array(),
								'FINALIZADA' => array()

							),
							
							9 => array (
							
									'PRE-ANALISE' => array('RESTRIÇÃO','GRAVAR','DEVOLVIDO', 'SEM COBERTURA'),
									'ANÁLISE' => array('APROVADO','RESTRIÇÃO'),
									'GRAVAR' => array('APROVADO','SEM CONTATO','DEVOLVIDO', 'ANÁLISE'),
									'APROVADO' => array('ANÁLISE','INSTALAR'),
									'DEVOLVIDO' => array('CANCELADO','RECUPERADO'),
									'SEM CONTATO' => array('CANCELADO','RECUPERADO'),
									'RESTRIÇÃO' => array(),
									'INSTALAR' => array('CANCELADO','CONECTADO'),
									'CANCELADO' => array(),
									'RECUPERADO' => array(),
									'CONECTADO' => array()
							),

							10 => array (
							
									'PRE-ANALISE' => array('RESTRIÇÃO','GRAVAR','DEVOLVIDO', 'SEM COBERTURA'),
									'ANÁLISE' => array('APROVADO','RESTRIÇÃO'),
									'GRAVAR' => array('APROVADO','SEM CONTATO','DEVOLVIDO', 'ANÁLISE'),
									'APROVADO' => array('ANÁLISE','INSTALAR'),
									'DEVOLVIDO' => array('CANCELADO','RECUPERADO'),
									'SEM CONTATO' => array('CANCELADO','RECUPERADO'),
									'RESTRIÇÃO' => array(),
									'INSTALAR' => array('CANCELADO','CONECTADO'),
									'CANCELADO' => array(),
									'RECUPERADO' => array(),
									'CONECTADO' => array()
							)

					
						);
						
	private $fluxoExcept = array (

								7 => array(

									'AGENDADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('AGENDADO','VISTORIAR','INSERIR DOCUMENTOS','CANCELADO','FINALIZADA')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'VISTORIAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('AGENDADO','VISTORIAR','INSERIR DOCUMENTOS','CANCELADO','FINALIZADA')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'INSERIR DOCUMENTOS' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('AGENDADO','VISTORIAR','INSERIR DOCUMENTOS','CANCELADO','FINALIZADA')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'CANCELADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('AGENDADO','VISTORIAR','INSERIR DOCUMENTOS','CANCELADO','FINALIZADA')
													
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
																
																'flux' => array('AGENDADO','VISTORIAR','INSERIR DOCUMENTOS','CANCELADO','FINALIZADA')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									)

								),

								1 => array(

									'PRE-ANALISE' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'ANÁLISE' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'GRAVAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'APROVADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'DEVOLVIDO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array('RECUPERADO')

													)
									),

									'SEM CONTATO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
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
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'INSTALAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'CANCELADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'CONECTADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									)

								),

								9 => array(

									'PRE-ANALISE' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'ANÁLISE' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'GRAVAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'APROVADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'DEVOLVIDO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array('RECUPERADO')

													)
									),

									'SEM CONTATO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
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
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'INSTALAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'CANCELADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'CONECTADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									)

								),
								
								2 => array (
								
									'PRE-ANALISE' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)

									),

									'DEVOLVIDO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array('RECUPERADO')

													)

									),

									'RESTRIÇÃO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)

									),

									'GRAVAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
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
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													),

													'entregaMR' => array(
																
																'==' => array (
																	
																		'Venda.tipoEntrega' => array('MR'),
																		),
																'flux' => array('RESTRIÇÃO','ENTREGAR')

													)

									),

									'SEM CONTATO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)

									),

									'RECUPERADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)

									),

									'CANCELADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)

									),

									'AUTORIZADA' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)

									),


									'ENTREGAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)

									),

									'ATIVADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																//'flux' => array('PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','PÓS VENDAS','ATIVADO')
																'flux' => array('ENTREGAR','PRE-ANALISE','DEVOLVIDO','RESTRIÇÃO','GRAVAR','GRAVADO','SEM CONTATO','RECUPERADO','CANCELADO','AUTORIZADA','ATIVADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)

									)


								),
								
								
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

									'BLOQUEADA' => array (
													
													'userAdmin' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																'flux' => array('PRE-ANALISE', 'CANCELADO')

													),
													
													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),
									'CONSULTA' => array (

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
			
								),

								10 => array(

									'PRE-ANALISE' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'ANÁLISE' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'GRAVAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'APROVADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'DEVOLVIDO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array('RECUPERADO')

													)
									),

									'SEM CONTATO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
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
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'INSTALAR' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'CANCELADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
													),

													'blockUserMonitorExterno' => array(
																
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('MONITOR'),
																		'Usuarios.acesso_usuario' => array('EXTERNO')
																		),
																'flux' => array()

													)
									),

									'CONECTADO' => array (
													
													'userAdmin' => array(
													
																'==' => array (
																	
																		'Usuarios.tipo_usuario' => array('ADMINISTRADOR')
																		),
																
																'flux' => array('PRE-ANALISE','ANÁLISE','GRAVAR','APROVADO','DEVOLVIDO','SEM CONTATO','RESTRIÇÃO','INSTALAR','CANCELADO','CONECTADO')
													
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
		
		unset($allStatus[array_search('Recuperado', $allStatus)]);
		
		asort($allStatus);

		return $allStatus;
	}
	
}

?>
