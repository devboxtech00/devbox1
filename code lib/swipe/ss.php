<?php 


		$array_menu = wp_get_nav_menu_items($current_menu);
							$menu = array();
							foreach ($array_menu as $m) {
								if (empty($m->menu_item_parent)) {
									$menu[$m->ID] = array();
									$menu[$m->ID]['ID']      =   $m->ID;
									$menu[$m->ID]['title']       =   $m->title;
									$menu[$m->ID]['url']         =   $m->url;
									$menu[$m->ID]['children']    =   [];

                                }

								if($m->menu_item_parent == $menu[$m->ID]['ID']){
									$submenu[$m->ID]['ID']       =   $m->ID;
									$submenu[$m->ID]['title']    =   $m->title;
									$submenu[$m->ID]['url']  =   $m->url;
								}
							}
							$submenu = array();
							foreach ($array_menu as $m) {
								if ($m->menu_item_parent) {
								$submenu[$m->ID] = array();
									$submenu[$m->ID]['ID']       =   $m->ID;
									$submenu[$m->ID]['title']    =   $m->title;
									$submenu[$m->ID]['url']  =   $m->url;
									$submenu[$m->ID]['children_sub']    =   array();
								    $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
								
								   
								}
							}

							$submenu_level_2 = array();

							foreach ($array_menu as $m) {
								if ($m->menu_item_parent) {
									   $submenu_level_2[$m->ID] = array();
									   $submenu_level_2[$m->ID]['ID']       =   $m->ID;
									   $submenu_level_2[$m->ID]['title']    =   $m->title;
									   $submenu_level_2[$m->ID]['url']  =   $m->url;
									   $submenu[$m->menu_item_parent]['children_2'][$m->ID] = $submenu_level_2[$m->ID];
									   
									}

							}

							return $menu;