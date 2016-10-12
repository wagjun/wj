<?php

class NDS extends Ldap {
	
	
	private $attributes;

	
	private $arvore;
	
	
	protected $ldap; 
	
	
	public function __construct( $aConnectionData ) {
		
		$this->ldap = parent::__construct( $aConnectionData );
	}
	

	public function conectaNds () {
		
		return $this->ldap;
	}
	
	
	public function getAtributos ( $arvore ) {
		
		$this->selecionaAtributos( $arvore );
		
		return $this->attributes;
	}
	
	
	public function selecionaAtributos ( $arvore ) {
	
		
		$this->arvore = $arvore;
		
		
		switch ( $this->arvore ) {
			 
			case 'contasservico':
				$this->attributes = array (
											'cn','dn','createtimestamp','brtnomecompleto','brtbirthdate','description','brtcpf','mail','brtmarstatus','brtnomepai','brtnomemae','brtcargo',
											'brtctcargo','brttelefone','brtcttelefone','brtcelular','brtrgnumber','brtrgorgao','brtrguf','brtultimoacessogsenhas','brtdataultimaconfigsenha',
											'passwordexpirationtime','passwordexpirationinterval','brtvpn0auth','brt0800auth','brtgerentedn','brtctgerenteuserid','brtdeptid','brtctgerentedeptid',
											'brtdescrdeptid','brtdescrlocation','brtctlocation','brtcodempresa','brtctempresa','brtcoddiretoria','brtdataatualizacao','brtclfyauth','brtstraauth',
											'brtracfauth','logindisabled','brtpof0auth','brtpeo1auth','logintime','pwdchangedtime','brtad00auth','brtad01auth','brtad02auth','brtgnv1auth','brtsap0auth',
											'brtsap1auth','brtsap2auth','oiidautorizados','oiidpeople','brtcontainerad','brtcontainerad01','brtbloqclfy','brtbloqgnv1','brtbloqstra','brtbloqracf',
											'brtbloqad00','brtbloqad01','brtbloqad02','brtbloqsap0','brtbloqsap1','brtbloqsap2','brtmxdrauth','brtbloqmxdr','brtnivelprofissional','brtdircauth',
											'brtdocnauth','brtga00auth','brtginfauth','brtinfpauth','brtlig0auth','brtmeacauth','brtpeduauth','brtpgovauth','oihabilitadobloqueioferias',
											'oidatasoldesbferias','oicommauth','oiexchauth','oisendauth','brtctmaster','brtdescrcbs','brtctsituacaofuncional','brtvpn0pool','brtvpn0grupo','brtemail',
											'brtbloqvpn0','brtbloq0800','brtctcontrato','creatorsname','rbsownedcollections2','brtmascauth','brtuserstatus','oivpnsartauth','oivpntelefone',
											'brtperfilacessoclf0','oiccenauth','oiblindfpw','oisgl0auth','oisie6usrcorrespond','oiidecadop','oiscelauth','oiloginadtelemar','oimailexch','oipdv',
											'passportuesp','passportvpn','oiusrcorresp','rbsassingnedroles2','nrbsfperfisrecurso','nrbsftransacoes','nrbsftransacaoid','oivendefilial',
											'groupmembership','oiaprovadordn','brtresponsavel','brtaplicacaocontaservico','brtdescription');
				break;
	
			case 'terceiros':
				$this->attributes = array (
											'cn','dn','createtimestamp','brtnomecompleto','brtbirthdate','description','brtcpf','mail','brtmarstatus','brtnomepai','brtnomemae','brtcargo',
											'brtctcargo','brttelefone','brtcttelefone','brtcelular','brtrgnumber','brtrgorgao','brtrguf','brtultimoacessogsenhas','brtdataultimaconfigsenha',
											'passwordexpirationtime','passwordexpirationinterval','brtvpn0auth','brt0800auth','brtgerentedn','brtctgerenteuserid','brtdeptid','brtctgerentedeptid',
											'brtdescrdeptid','brtdescrlocation','brtctlocation','brtcodempresa','brtctempresa','brtcoddiretoria','brtdataatualizacao','brtclfyauth','brtstraauth',
											'brtracfauth','logindisabled','brtpof0auth','brtpeo1auth','logintime','pwdchangedtime','brtad00auth','brtad01auth','brtad02auth','brtgnv1auth',
											'brtsap0auth','brtsap1auth','brtsap2auth','oiidautorizados','oiidpeople','brtcontainerad','brtcontainerad01','brtbloqclfy','brtbloqgnv1','brtbloqstra',
											'brtbloqracf','brtbloqad00','brtbloqad01','brtbloqad02','brtbloqsap0','brtbloqsap1','brtbloqsap2','brtmxdrauth','brtbloqmxdr','brtnivelprofissional',
											'brtdircauth','brtdocnauth','brtga00auth','brtginfauth','brtinfpauth','brtlig0auth','brtmeacauth','brtpeduauth','brtpgovauth','oihabilitadobloqueioferias',
											'oidatasoldesbferias','oicommauth','oiexchauth','oisendauth','brtctmaster','brtdescrcbs','brtctsituacaofuncional','brtvpn0pool','brtvpn0grupo','brtemail',
											'brtbloqvpn0','brtbloq0800','brtctcontrato','creatorsname','rbsownedcollections2','brtmascauth','brtuserstatus','oivpnsartauth','oivpntelefone',
											'brtperfilacessoclf0','oiccenauth','oiblindfpw','oisgl0auth','oisie6usrcorrespond','oiidecadop','oiscelauth','oiloginadtelemar','oimailexch','oipdv',
											'passportuesp','passportvpn','oiusrcorresp','rbsassingnedroles2','nrbsfperfisrecurso','nrbsftransacoes','nrbsftransacaoid','oivendefilial',
											'groupmembership','oiaprovadordn');
				break;
	
			case 'colaboradores':
				$this->attributes = array (
											'cn','dn','createtimestamp','brtnomecompleto','brtbirthdate','description','brtcpf','mail','brtmarstatus','brtnomepai','brtnomemae','brtcargo',
											'brtctcargo','brttelefone','brtcttelefone','brtcelular','brtrgnumber','brtrgorgao','brtrguf','brtultimoacessogsenhas','brtdataultimaconfigsenha',
											'passwordexpirationtime','passwordexpirationinterval','brtvpn0auth','brt0800auth','brtgerentedn','brtctgerenteuserid','brtdeptid','brtctgerentedeptid',
											'brtdescrdeptid','brtdescrlocation','brtctlocation','brtcodempresa','brtctempresa','brtcoddiretoria','brtdataatualizacao','brtclfyauth','brtstraauth',
											'brtracfauth','logindisabled','brtpof0auth','brtpeo1auth','logintime','pwdchangedtime','brtad00auth','brtad01auth','brtad02auth','brtgnv1auth',
											'brtsap0auth','brtsap1auth','brtsap2auth','oiidautorizados','oiidpeople','brtcontainerad','brtcontainerad01','brtbloqclfy','brtbloqgnv1','brtbloqstra',
											'brtbloqracf','brtbloqad00','brtbloqad01','brtbloqad02','brtbloqsap0','brtbloqsap1','brtbloqsap2','brtmxdrauth','brtbloqmxdr','brtnivelprofissional',
											'brtdircauth','brtdocnauth','brtga00auth','brtginfauth','brtinfpauth','brtlig0auth','brtmeacauth','brtpeduauth','brtpgovauth','oihabilitadobloqueioferias',
											'oidatasoldesbferias','oicommauth','oiexchauth','oisendauth','brtctmaster','brtdescrcbs','brtctsituacaofuncional','brtvpn0pool','brtvpn0grupo','brtemail',
											'brtbloqvpn0','brtbloq0800','brtctcontrato','creatorsname','rbsownedcollections2','brtmascauth','brtuserstatus','oivpnsartauth','oivpntelefone',
											'brtperfilacessoclf0','oiccenauth','oiblindfpw','oisgl0auth','oisie6usrcorrespond','oiidecadop','oiscelauth','oiloginadtelemar','oimailexch','oipdv',
											'passportuesp','passportvpn','oiusrcorresp','rbsassingnedroles2','nrbsfperfisrecurso','nrbsftransacoes','nrbsftransacaoid','oivendefilial',
											'groupmembership','oiaprovadordn');
				break;
	
			case 'inativos':
				$this->attributes = array (
											'cn','dn','createtimestamp','brtnomecompleto','brtbirthdate','description','brtcpf','mail','brtmarstatus','brtnomepai','brtnomemae','brtcargo','brtctcargo',
											'brttelefone','brtcttelefone','brtcelular','brtrgnumber','brtrgorgao','brtrguf','brtultimoacessogsenhas','brtdataultimaconfigsenha','passwordexpirationtime',
											'passwordexpirationinterval','brtvpn0auth','brt0800auth','brtgerentedn','brtctgerenteuserid','brtdeptid','brtctgerentedeptid','brtdescrdeptid',
											'brtdescrlocation','brtctlocation','brtcodempresa','brtctempresa','brtcoddiretoria','brtdataatualizacao','brtclfyauth','brtstraauth','brtracfauth',
											'logindisabled','brtpof0auth','brtpeo1auth','logintime','pwdchangedtime','brtad00auth','brtad01auth','brtad02auth','brtgnv1auth','brtsap0auth',
											'brtsap1auth','brtsap2auth','oiidautorizados','oiidpeople','brtcontainerad','brtcontainerad01','brtbloqclfy','brtbloqgnv1','brtbloqstra','brtbloqracf',
											'brtbloqad00','brtbloqad01','brtbloqad02','brtbloqsap0','brtbloqsap1','brtbloqsap2','brtmxdrauth','brtbloqmxdr','brtnivelprofissional','brtdircauth',
											'brtdocnauth','brtga00auth','brtginfauth','brtinfpauth','brtlig0auth','brtmeacauth','brtpeduauth','brtpgovauth','oihabilitadobloqueioferias',
											'oidatasoldesbferias','oicommauth','oiexchauth','oisendauth','brtctmaster','brtdescrcbs','brtctsituacaofuncional','brtvpn0pool','brtvpn0grupo',
											'brtemail','brtbloqvpn0','brtbloq0800','brtctcontrato','creatorsname','rbsownedcollections2','brtmascauth','brtuserstatus','oivpnsartauth',
											'oivpntelefone','brtperfilacessoclf0','oiccenauth','oiblindfpw','oisgl0auth','oisie6usrcorrespond','oiidecadop','oiscelauth','oiloginadtelemar',
											'oimailexch','oipdv','passportuesp','passportvpn','oiusrcorresp','rbsassingnedroles2','nrbsfperfisrecurso','nrbsftransacoes','nrbsftransacaoid',
											'oivendefilial','groupmembership','oiaprovadordn');
				break;
	
			case 'clientes':
				$this->attributes = array (
											'cn','dn','createtimestamp','brtnomecompleto','brtbirthdate','description','brtcpf','mail','brtmarstatus','brtnomepai','brtnomemae','brtcargo','brtctcargo',
											'brttelefone','brtcttelefone','brtcelular','brtrgnumber','brtrgorgao','brtrguf','brtultimoacessogsenhas','brtdataultimaconfigsenha','passwordexpirationtime',
											'passwordexpirationinterval','brtvpn0auth','brt0800auth','brtgerentedn','brtctgerenteuserid','brtdeptid','brtctgerentedeptid','brtdescrdeptid','brtdescrlocation',
											'brtctlocation','brtcodempresa','brtctempresa','brtcoddiretoria','brtdataatualizacao','brtclfyauth','brtstraauth','brtracfauth','logindisabled','brtpof0auth',
											'brtpeo1auth','logintime','pwdchangedtime','brtad00auth','brtad01auth','brtad02auth','brtgnv1auth','brtsap0auth','brtsap1auth','brtsap2auth','oiidautorizados',
											'oiidpeople','brtcontainerad','brtcontainerad01','brtbloqclfy','brtbloqgnv1','brtbloqstra','brtbloqracf','brtbloqad00','brtbloqad01','brtbloqad02','brtbloqsap0',
											'brtbloqsap1','brtbloqsap2','brtmxdrauth','brtbloqmxdr','brtnivelprofissional','brtdircauth','brtdocnauth','brtga00auth','brtginfauth','brtinfpauth','brtlig0auth',
											'brtmeacauth','brtpeduauth','brtpgovauth','oihabilitadobloqueioferias','oidatasoldesbferias','oicommauth','oiexchauth','oisendauth','brtctmaster','brtdescrcbs',
											'brtctsituacaofuncional','brtvpn0pool','brtvpn0grupo','brtemail','brtbloqvpn0','brtbloq0800','brtctcontrato','creatorsname','rbsownedcollections2','brtmascauth',
											'oivpnsartauth','oivpntelefone','brtperfilacessoclf0','oiccenauth','oiblindfpw','oisgl0auth','oisie6usrcorrespond','oiidecadop','oiscelauth','oiloginadtelemar',
											'oimailexch','oipdv','passportuesp','passportvpn','oiusrcorresp','rbsassingnedroles2','nrbsfperfisrecurso','nrbsftransacoes','nrbsftransacaoid','oivendefilial',
											'groupmembership','oiaprovadordn');
				break;
	
			case 'conselheiros':
				$this->attributes = array (
											'cn','dn','createtimestamp','brtnomecompleto','brtbirthdate','description','brtcpf','mail','brtmarstatus','brtnomepai','brtnomemae','brtcargo','brtctcargo',
											'brttelefone','brtcttelefone','brtcelular','brtrgnumber','brtrgorgao','brtrguf','brtultimoacessogsenhas','brtdataultimaconfigsenha','passwordexpirationtime',
											'passwordexpirationinterval','brtvpn0auth','brt0800auth','brtgerentedn','brtctgerenteuserid','brtdeptid','brtctgerentedeptid','brtdescrdeptid','brtdescrlocation',
											'brtctlocation','brtcodempresa','brtctempresa','brtcoddiretoria','brtdataatualizacao','brtclfyauth','brtstraauth','brtracfauth','logindisabled','brtpof0auth',
											'brtpeo1auth','logintime','pwdchangedtime','brtad00auth','brtad01auth','brtad02auth','brtgnv1auth','brtsap0auth','brtsap1auth','brtsap2auth','oiidautorizados',
											'oiidpeople','brtcontainerad','brtcontainerad01','brtbloqclfy','brtbloqgnv1','brtbloqstra','brtbloqracf','brtbloqad00','brtbloqad01','brtbloqad02','brtbloqsap0',
											'brtbloqsap1','brtbloqsap2','brtmxdrauth','brtbloqmxdr','brtnivelprofissional','brtdircauth','brtdocnauth','brtga00auth','brtginfauth','brtinfpauth','brtlig0auth',
											'brtmeacauth','brtpeduauth','brtpgovauth','oihabilitadobloqueioferias','oidatasoldesbferias','oicommauth','oiexchauth','oisendauth','brtctmaster','brtdescrcbs',
											'brtctsituacaofuncional','brtvpn0pool','brtvpn0grupo','brtemail','brtbloqvpn0','brtbloq0800','brtctcontrato','creatorsname','rbsownedcollections2','brtmascauth',
											'brtuserstatus','oivpnsartauth','oivpntelefone','brtperfilacessoclf0','oiccenauth','oiblindfpw','oisgl0auth','oisie6usrcorrespond','oiidecadop','oiscelauth',
											'oiloginadtelemar','oimailexch','oipdv','passportuesp','passportvpn','oiusrcorresp','rbsassingnedroles2','nrbsfperfisrecurso','nrbsftransacoes','nrbsftransacaoid',
											'oivendefilial','groupmembership','oiaprovadordn');
				break;
	
			case 'domainadmins':
				$this->attributes = array (
											'cn','dn','createtimestamp','brtnomecompleto','brtbirthdate','description','brtcpf','mail','brtmarstatus','brtnomepai','brtnomemae','brtcargo','brtctcargo',
											'brttelefone','brtcttelefone','brtcelular','brtrgnumber','brtrgorgao','brtrguf','brtultimoacessogsenhas','brtdataultimaconfigsenha','passwordexpirationtime',
											'passwordexpirationinterval','brtvpn0auth','brt0800auth','brtgerentedn','brtctgerenteuserid','brtdeptid','brtctgerentedeptid','brtdescrdeptid','brtdescrlocation',
											'brtctlocation','brtcodempresa','brtctempresa','brtcoddiretoria','brtdataatualizacao','brtclfyauth','brtstraauth','brtracfauth','logindisabled','brtpof0auth',
											'brtpeo1auth','logintime','pwdchangedtime','brtad00auth','brtad01auth','brtad02auth','brtgnv1auth','brtsap0auth','brtsap1auth','brtsap2auth','oiidautorizados',
											'oiidpeople','brtcontainerad','brtcontainerad01','brtbloqclfy','brtbloqgnv1','brtbloqstra','brtbloqracf','brtbloqad00','brtbloqad01','brtbloqad02','brtbloqsap0',
											'brtbloqsap1','brtbloqsap2','brtmxdrauth','brtbloqmxdr','brtnivelprofissional','brtdircauth','brtdocnauth','brtga00auth','brtginfauth','brtinfpauth','brtlig0auth',
											'brtmeacauth','brtpeduauth','brtpgovauth','oihabilitadobloqueioferias','oidatasoldesbferias','oicommauth','oiexchauth','oisendauth','brtctmaster','brtdescrcbs',
											'brtctsituacaofuncional','brtvpn0pool','brtvpn0grupo','brtemail','brtbloqvpn0','brtbloq0800','brtctcontrato','creatorsname','rbsownedcollections2','brtmascauth',
											'oivpnsartauth','oivpntelefone','brtperfilacessoclf0','oiccenauth','oiblindfpw','oisgl0auth','oisie6usrcorrespond','oiidecadop','oiscelauth','oiloginadtelemar',
											'oimailexch','oipdv','passportuesp','passportvpn','oiusrcorresp','rbsassingnedroles2','nrbsfperfisrecurso','nrbsftransacoes','nrbsftransacaoid','oivendefilial',
											'groupmembership','oiaprovadordn');
				break;
		}
	
	}
	
	
	private function montaMatrizUsuariosNds () {
	
		$array = array();
		$i     = 0;
	
		foreach ( $this->consultaUsuariosNds() as $index => $e ) {
			 
			foreach ( $this->attributes as $attr ) {
	
				if ( isset ( $e[$attr][0] ) ) {
						
					$array[$i][$attr] = ( $e[$attr][0]!='c' ) ? $e[$attr][0] : $e[$attr];
				}
			}
	
			$i++;
		}
	
		return $array;
	}
	
	
	private function consultaUsuariosNds () {
	
		$query	 = array (
							'base_dn'	=> 'ou=' . $this->arvore . ',ou=usuarios,ou=brt,o=btp',
							'filter'  	=> "(CN=*)",
							'attribute'	=> $this->attributes
		);
	
		$this->query( $query );
	
		return $this->data();
	}

	
	public function consultaUsuariosNdsNovo () {
		
		$query	 = array (
				'base_dn'	=> 'ou=usuarios,ou=brt,o=btp',
				'filter'  	=> "(CN=*)",
				'attribute'	=> $this->attributes
		);
		
		$this->query( $query );
		
		return $this->data();
		
		
	}

	
	public function consultaGrupoNds () {
		
		$query	 = array (
							'base_dn'	=> 'ou=' . $this->arvore . ',ou=usuarios,ou=brt,o=btp',
							'filter'  	=> "(CN=*)",
							'attribute'	=> $this->attributes
		);
		
		$this->query( $query );
		
		return $this->data();
	}
	
}