<?php
$menu_tpl = ['menu_prefix'   => '<ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">',
             'menu_postfix' => '</ul>',

             'submenu_prefix' => '<li class="nav-item has-treeview">
                <a href="#" class="nav-link"> {icon} <p> {caption} <i class="right fas fa-angle-left"></i> </p> </a>
                <ul class="nav nav-treeview">',
                
             'submenu_prefix_open' => '<li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active"> {icon} <p> {caption} <i class="right fas fa-angle-left"></i> </p> </a>
                <ul class="nav nav-treeview">',

             'submenu_postfix' => '</ul></li>',

             'menulink' => '<li class="nav-item">
                              <a href="{link}" class="nav-link">{icon}
                                <p>{caption}</p>
                              </a>
                            </li>',

             'menulink_open' => '<li class="nav-item">
                              <a href="{link}" class="nav-link active">{icon}
                                <p>{caption}</p>
                              </a>
                            </li>',

             'menucaption' => '<li class="nav-header>{caption}</li>',
            ];