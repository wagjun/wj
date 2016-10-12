<?php

Class Menu {

	
	public function arvoreMenu (array $menu, $idPai = 0, $nivel = 0) {
	
		switch ($nivel) {
	
			case 0:
				$tag 		= '<ul id="menu-topo" class="menu-principal">';
				$fechaTag 	= '</ul>';
				break;
			case 1:
				$tag 		= '<ul class="sub-menu">';
				$fechaTag 	= '</ul>';
				break;
			case 2:
				$tag 		= '<ol>';
				$fechaTag 	= '</ol>';
				break;
		}
	
		echo $tag;
	
		foreach ($menu[$idPai] as $idMenu => $menuItem) {
	
			echo '<li><a href="' . BASE_URL . $menuItem['link'] . '">' . utf8_encode($menuItem['name']) . '</a>';
	
			if (isset($menu[$idMenu])) {
				
				$this->arvoreMenu($menu, $idMenu, $nivel + 1);
			}
			
			echo '</li>';
		}
	
		echo $fechaTag;
	}
}