<?php
namespace booosta\adminlte;

\booosta\Framework::add_module_trait('webapp', 'adminlte\webapp');
\booosta\Framework::add_module_trait('ui_select1', 'adminlte\ui_select1');

trait webapp
{
  protected $select_class = 'form-control default';
  protected $select_prefix = '<div class="form-group"><label for="{name}" class="col-form-label">{caption}</label>';
  protected $select_postfix = '</div>';

  protected function adminlte3_collapse_menu($collapse)
  {
    $this->TPL['collapse_menu'] = $collapse ? 'sidebar-collapse' : ''; 
  }
}


trait ui_select1
{
  protected $select_class = 'form-control default';
  protected $select_prefix = '<div class="form-group"><label for="{name}" class="col-form-label">{caption}</label>';
  protected $select_postfix = '</div>';
}
