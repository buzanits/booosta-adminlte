<?php
namespace booosta\adminlte;
use \booosta\Framework as b;

b::add_module_trait('webapp', 'adminlte\webapp');
b::add_module_trait('ui_select1', 'adminlte\ui_select1');

b::$module_config['adminlte']['menu_default_icon'] = '<i class="nav-icon far fa-circle"></i>';

trait webapp
{
  protected function adminlte3_collapse_menu($collapse)
  {
    $this->TPL['collapse_menu'] = $collapse ? 'sidebar-collapse' : ''; 
  }
  
  protected function webappinit_adminlte()
  {
    if($this->config('template_module') == 'adminlte'):
      $this->select_class = 'form-control default';
      $this->select_prefix = '<div class="form-group"><label for="{name}" class="col-form-label">{caption}</label>';
      $this->select_postfix = '</div>';

      $this->edit_pic_code = '<span class="text-default fas fa-edit" title="edit"></span>';
      $this->delete_pic_code = '<span class="text-danger far fa-trash-alt" title="delete"></span>';
    endif;
  }
}


trait ui_select1
{
  protected $select_class = 'form-control default';
  protected $select_prefix = '<div class="form-group"><label for="{name}" class="col-form-label">{caption}</label>';
  protected $select_postfix = '</div>';
}
