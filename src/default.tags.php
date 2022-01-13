<?php
namespace booosta\templateparser;

BootstrapTags::load();

class TemplatemoduleTags extends Tags
{
  public function __construct()
  {
    parent::__construct();

    $this->scripttags = [
    
        'BFORMSTARTG'    => "<form name='form0' method='get' class='form-horizontal' role='form' action='%1' %2 onSubmit='return checkForm();' %_>",
        'RTEXT'          => "<div class='form-group'>
                                <label for='%1' class='col-sm-%size control-label'>%texttitle</label>
                                <div class='col-sm-%rasize'>
                                  <input type='text' name='%1' value='%2' class='form-control %class' id='%1' %_>
                                </div>
                                <div class='col-sm-%rsize brighttext'>",
        '/RTEXT'         => "</div></div>",
        'BFORMGRPEND'    => '</div></div>',
        'BFORMEND'       => '</form>',
        'BBOXCENTEREND'  => '</div></div>',
        'BBOXSTART'      => '<div class="row %class">',
        'BBOXEND'        => '</div>',
        'BCOLEND'        => '</div>',
        'BCENTERSTART'   => '<div style="text-align:center">',
        'BCENTEREND'     => '</div>',
        'BUTTONGROUP'    => '<div class="btn-group">',
        'BUTTONGROUPEND' => '</div>',

        'BBUTTON'         => "<input type='button' name='%1' id='%1' value='%2' class='btn btn-%btn-color %class' %_>",
        'BBUTTON1'        => "<button name='%1' id='%1' value='%2' class='btn btn-%btn-color %class' %_>%2</button>",

        'REDALERT'       => "<div class='alert alert-danger' role='alert'><center>%1</center></div>",
        'GREENALERT'     => "<div class='alert alert-success' role='alert'><center>%1</center></div>",
        'BPLAIN'         => '%1',
 
    ];
    
    $this->aliases = [
    
      'BFORM'         => 'BFORMSTART',
      '/BFORM'        => 'BFORMEND',
      'BFORMGRP'      => 'BFORMGRPSTART',
      '/BFORMGRP'     => 'BFORMGRPEND',
      'BCENTER'       => 'BCENTERSTART',
      '/BCENTER'      => 'BCENTEREND',
      '/BPANEL'       => 'BPANELEND',
      '/BPANELTOOLS'  => 'BPANELTOOLSEND',
      '/BPANELPANEL'  => 'BPANELENDPANEL',
      '/BPANELFOOTER' => 'BPANELFOOTEREND',
      '/BBOXCENTER'   => 'BBOXCENTEREND',
      '/BBOXSTART'    => 'BBOXEND',
      'BBOX'          => 'BBOXSTART',
      '/BBOX'         => 'BBOXEND',
      '/BCOL'         => 'BCOLEND',
      '/BUTTONGROUP'  => 'BUTTONGROUPEND',
      '/RTEXTAREA'    => '/RTEXT',

    ];
 

    $this->defaultvars = [

        'size'          => '4',
        'rsize'         => '4',
        'rasize'        => '4',
        'boxsize'      => '12,12,10,8',
        'buttontext'    => $this->t('apply'),
        'btn-color'     => 'primary',
        'panel-color'   => 'success',
        'panel-style'   => 'card-outline',
        'btn-icon'      => null,
        'form-horizontal' => 'false',
        'form-horizontal-size' => 2,
        
        'fhsize' => 2
        #'btn-icon'      => 'arrow',

    ];

    $defaulttags = $this->makeInstance("\\booosta\\templateparser\\BootstrapTags");
    $this->merge($defaulttags);    
  }
} 


namespace booosta\templateparser\tags\adminlte;

class binfo extends \booosta\templateparser\Tag
{
  protected $html = '<div class="info-box %bgcolor">
                      <span class="info-box-icon %color">%iconcode</span>
                      <div class="info-box-content">
                        <span class="info-box-text">%1</span>
                        <span class="info-box-number">%2</span>
                        %progresscode
                      </div>
                    </div>';
  protected $htmlbig = '<div class="small-box %bgcolor">
                        <div class="inner">
                          <h3>%2</h3>
                          <p>%1</p>
                        </div>
                        <div class="icon">
                          %iconcode
                        </div>';
  protected $biglink = '<a href="%link" class="small-box-footer">
                          %linktext <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>';
  protected $iconcode = "<i class='%icon' aria-hidden='true'></i>";
  protected $progresscode = '<div class="progress">
                              <div class="progress-bar" style="width: %progress%"></div>
                             </div>
                             <span class="progress-description">
                                %progress-text
                             </span>';
  protected $fixattr = ['icon','color','link','bgcolor','progress','progress-text'];

  function precode ()
  {
    if($this->attributes['link']) $bigfooter = $this->biglink; else $bigfooter = '</div>';
    if($this->attributes['style']=="big") $this->html = $this->htmlbig . $bigfooter;
    if($this->attributes['linktext']) $this->html = str_replace("%linktext", $this->attributes['linktext'], $this->html);
    else $this->html = str_replace("%linktext","%link", $this->html);

    if($this->attributes['icon'])
      $this->html = str_replace("%iconcode", $this->iconcode, $this->html);
    else
      $this->html = str_replace("%iconcode", '', $this->html);

      //bgcolor set ==> größere Box mit Progress bar
      if($this->attributes['bgcolor']):
        $this->html = str_replace("%bgcolor", "bg-".$this->attributes['bgcolor'], $this->html);

        if($this->attributes['progress']):
          $this->progresscode = str_replace("%progress-text", $this->attributes['progress-text'], $this->progresscode);
          $this->progresscode = str_replace("%progress", $this->attributes['progress'], $this->progresscode);

          $this->html = str_replace("%progresscode", $this->progresscode, $this->html);
        endif;
      else:
        $this->html = str_replace("%bgcolor", "", $this->html);
      endif;

      $this->html = str_replace("%progresscode", "", $this->html);
      if($this->attributes['color'] && !$this->attributes['bgcolor']):
        $this->html = str_replace("%color", "bg-".$this->attributes['color'], $this->html);
      elseif(!$this->attributes['bgcolor']):
        $this->html = str_replace("%color", "bg-".$this->defaultvars['btn-color'], $this->html);
      else:
        $this->html = str_replace("%color", "", $this->html);
      endif;

      if($this->attributes['link'] && !$this->attributes['style'] == "big"):
        $this->html = "<a class='text-reset text-decoration-none' href='".$this->attributes['link']."'>".$this->html."</a>";
      endif;
    
  }
}

class blink extends \booosta\templateparser\Tag
{
  protected $html = '<a href="%2" class="%class" %_>%iconcode%1</a>';
  protected $btncode = "btn btn-%btn-color";
  protected $btncodeapp = "btn btn-app";
  protected $iconcode = "<span class='%btn-icon' aria-hidden='true'></span>&nbsp;";
  protected $fixattr = ['no-button','no-icon','size','badge','only-icon','btn-app'];

  function precode()
  {
    if($this->attributes['only-icon']) $this->attributes['2'] = $this->attributes['1'] && $this->attributes['1'] = "";

    $dest = $this->attributes[2];
    if(substr($dest, 0, 4) != 'http') $dest = str_replace('//', '/', $dest);
    $this->attributes[2] = $dest;

    if($this->attributes['no-button']) $this->btncode = "%class";
    if($this->attributes['btn-app']): 
      $this->btncode = $this->btncodeapp;
      $this->iconcode = "<span class='badge bg-%btn-color'>".$this->attributes['badge']."</span>".$this->iconcode;
    endif;
    $this->html = str_replace("%class", $this->btncode." %class", $this->html);

    if($this->attributes['size'] == "small"):
      $this->html = str_replace("%class", "btn-sm %class", $this->html);
    elseif($this->attributes['size'] == "large"):
      $this->html = str_replace("%class", "btn-lg %class", $this->html);
    elseif($this->attributes['size'] == "extra-small"):
      $this->html = str_replace("%class", "btn-xs %class", $this->html);
    endif;

    if($this->attributes['flat']) $this->html = str_replace("%class", "btn-flat %class", $this->html);
    if($this->attributes['disabled']) $this->html = str_replace("%class", "disabled %class", $this->html);

    if($this->attributes['btn-icon'] == "" || $this->fixattr['no-icon']) $this->iconcode = "";
    $this->html = str_replace("%iconcode", $this->iconcode, $this->html);
  }
}

// escape % in URLs
class blinkurl extends blink
{
  function precode()
  {
    parent::precode();
    $this->attributes[2] = str_replace('%', '__PCT__', $this->attributes[2]);
  }

  function postcode()
  {
    $this->html = str_replace('__PCT__', '%', $this->html);
  }
}

class blinkadd extends blink 
{
  function precode()
  {
    $this->attributes['btn-icon'] = "fas fa-plus-circle";
    $this->attributes['btn-color'] = "success";
    parent::precode();
  }
}

class blinkred extends blink 
{
  function precode()
  {
    $this->attributes['btn-icon'] = "fas fa-minus-circle";
    $this->attributes['btn-color'] = "danger";
    parent::precode();
  }
}

class blinkgreen extends blink 
{
  function precode()
  {
    $this->attributes['btn-icon'] = "fas fa-check-circle";
    $this->attributes['btn-color'] = "success";
    parent::precode();
  }
}


abstract class binput extends \booosta\templateparser\Tag
{
  protected $htmlhorizontal = "<div class='form-group row'>
                                <label for='%1' class='col-sm-%form-horizontal-size col-form-label'>%texttitle</label>
                                <div class='col-sm-%asize'>
                                  %inputcode
                                  %varhelp
                                </div>
                             </div>";

  protected $htmldefault = "<div class='form-group'>
                               %labelcode
                               %inputcode
                               %varhelp
                            </div>";

  protected $htmldefault_labelcode = "<label for='%1' class='col-form-label'>%texttitle</label>";

  protected $inputcode_prepend = "<div class='input-group-prepend'>
                                      <span class='input-group-text'>%inputcode_prepend_text</span>
                                  </div>
                                  %inputcode
                                  ";
  protected $inputcode_append = "%inputcode
                                <div class='input-group-append'>
                                  <div class='input-group-text'>
                                    %inputcode_append_text
                                  </div>
                                </div>";

  protected $validator_rules = [], $validator_messages = [];
  protected $validator = ['required' => ['rule' => 'required: true, ', 'default_error' => 'Please enter this field'], 
                          'minlength' => ['rule' => 'minlength: {value}, ', 'default_error' => 'The minimal length is {value}'], 
                          'maxlength' => ['rule' => 'maxlength: {value}, ', 'default_error' => 'The maximal length is {value}'],
                          'rangelength' => ['rule' => 'rangelength: [{value}], ', 'default_error' => 'The allowed length range is {value}'],
                          'min' => ['rule' => 'min: {value}, ', 'default_error' => 'The minimal value is {value}'],
                          'max' => ['rule' => 'max: {value}, ', 'default_error' => 'The maximal value is {value}'],
                          'range' => ['rule' => 'range: [{value}], ', 'default_error' => 'The allowed range is {value}'],
                          'step' => ['rule' => 'step: {value}, ', 'default_error' => 'The value has to be a multiple of {value}'],
                          'email' => ['rule' => 'email: true, ', 'default_error' => 'Please enter a valid email address'], 
                          'url' => ['rule' => 'url: true, ', 'default_error' => 'Please enter a valid URL'],
                          'date' => ['rule' => 'date: true, ', 'default_error' => 'Please enter a valid date'], 
                          'dateDE' => ['rule' => 'dateDE: true, ', 'default_error' => 'Please enter a valid date'], 
                          'dateISO' => ['rule' => 'dateISO: true, ', 'default_error' => 'Please enter a valid ISO date (YYYY-MM-DD)'],
                          'number' => ['rule' => 'number: true, ', 'default_error' => 'Please enter a number'],
                          'digits' => ['rule' => 'digits: true, ', 'default_error' => 'Please enter only digits'],
                          'equalTo' => ['rule' => 'equalTo: "#{value}", ', 'default_error' => 'The value has to be a the same like in {value}'],
                          'requireFileExtension' => ['rule' => 'requireFileExtension: "{value}", ', 'default_error' => 'Illegal file extension'],
                          'requiredIfNotEmpty' => ['rule' => 'requiredIfNotEmpty: "#{value}", ', 'default_error' => 'Please enter this field']
                        ];

  protected $data_saved = false;
  
  protected $alwaysfixattr = ['help','prepend-icon','prepend-text'];
  protected $fixattr = [];
                          
  public function __construct($code, $defaultvars = [], $attributes = [], $extraattributes = [], $html = null)
  {
    $this->fixattr = array_merge($this->alwaysfixattr, $this->fixattr);
    if(is_readable('incl/default.tags.validator.php')) $this->validator = array_merge($this->validator, include 'incl/default.tags.validator.php');

    parent::__construct($code, $defaultvars, $attributes, $extraattributes, $html);
  }
                          
  protected function precode()
  {
    if($this->extraattributes['form-horizontal'])
      $this->html = $this->htmlhorizontal;
    else
      $this->html = $this->htmldefault;
      
    if($this->attributes['append-icon']) $this->attributes['append-text'] = "<i class='".$this->attributes['append-icon']."'></i>";
    if($this->attributes['append-text']):
      $this->inputcode_append = str_replace("%inputcode_append_text", $this->attributes['append-text'], $this->inputcode_append);
      $this->inputcode = str_replace("%inputcode", $this->inputcode, $this->inputcode_append);
    endif;

    if($this->attributes['no-prepend-icon']) unset($this->attributes['prepend-icon']);
    if($this->attributes['prepend-icon']) $this->attributes['prepend-text'] = "<i class='".$this->attributes['prepend-icon']."'></i>";
    if($this->attributes['prepend-text']):
      $this->inputcode_prepend = str_replace("%inputcode_prepend_text", $this->attributes['prepend-text'], $this->inputcode_prepend);
      $this->inputcode = str_replace("%inputcode", $this->inputcode, $this->inputcode_prepend);
    endif;

    if($this->attributes['append-text'] || $this->attributes['prepend-text'])
      $this->inputcode = "<div class='input-group'>".$this->inputcode."</div>";
    

    $this->html = str_replace("%inputcode", $this->inputcode, $this->html);

    if($this->attributes['texttitle'] == '') $this->attributes['texttitle'] = $this->attributes[1];
    #\booosta\debug($this->attributes);
    #\booosta\debug($this->extraattributes);
    #if(!array_key_exists('texttitle', $this->attributes)) $this->attributes['texttitle'] = $this->attributes[1];

    if($this->attributes['help']):
      $this->html = str_replace("%varhelp", "<small id='%1_helpblock' class='form-text text-muted'>" . $this->attributes['help']."</small>", $this->html);
    else:
      $this->html = str_replace("%varhelp", '', $this->html);
    endif;

    if(array_key_exists('texttitle', $this->extraattributes) && $this->extraattributes['texttitle'] == ''):
      $this->html = str_replace("%labelcode", '', $this->html);
    else:
      $this->html = str_replace("%labelcode", $this->htmldefault_labelcode, $this->html);
    endif;

    // set JS for required fields
    $this->name = $this->attributes[1];
    foreach($this->validator as $key=>$config):
      if($value = $this->attributes["val-$key"]):
        $this->validator_rules[$key] = str_replace('{value}', $value, $config['rule']);

        $validator_error = $this->attributes["val-err-$key"] ?? $this->t($config['default_error']);
        $validator_error = str_replace('{value}', $value, $validator_error);
        $message = $config['message'] ?? "$key: \"{message}\", ";
        $this->validator_messages[$key] = str_replace('{message}', $validator_error, $message);

        // do not show these as extraattributes
        $this->fixattr[] = "val-$key";
        $this->fixattr[] = "val-err-$key";
      endif;
    endforeach;
  }

  protected function postcode()
  {
    if(!$this->data_saved) $this->default_save_data();
    $this->html = str_replace("%asize", 12-$this->extraattributes['form-horizontal-size'], $this->html);
  }

  protected function default_save_data()
  {
    $name = $this->name ?: $this->attributes[1];
    
    $rules = $messages = '';
    foreach($this->validator_rules as $key=>$rule) $rules .= $rule;
    foreach($this->validator_messages as $key=>$message) $messages .= $message;

    $current_form = $this->get_data('current-form');
    if($rules) $this->save_data_sub('form-rules', $current_form, "$name: { $rules },\n");
    if($messages) $this->save_data_sub('form-messages', $current_form, "$name: { $messages },\n");

    $this->data_saved = true;
  }
}


class btext extends binput 
{
  protected $fixattr = ["readonly"];
  protected $inputcode = "<input type='text' name='%1' value='%2' class='%readonly %class' id='%1' aria-describedby='%1_helpblock' %_>";

  protected function precode()
  {
    parent::precode();
    if($this->attributes['readonly'] == true):
      $this->html = str_replace("%readonly", "form-control-plaintext", $this->html);
    else:
      $this->html = str_replace("%readonly", 'form-control', $this->html);
    endif;

    #\booosta\debug($this->attributes);
    if($this->attributes[3]) $this->attributes['texttitle'] = $this->attributes[3];
    #\booosta\debug($this->attributes);
  }
}

class bfile extends btext{
  protected $inputcode = "<input type='file' name='%1' id='%1' class='inputfile inputfile-6' data-multiple-caption='{count} files selected' multiple='' %_>
                            <label for='%1' class='inputfile-label'> 
                              <strong>
                                <i class='fas fa-file-alt'></i>
                              </strong>
                              <span></span>
                            </label>";
}

class bemail extends binput
{
  protected $inputcode = "<input type='email' name='%1' value='%2' class='form-control %class' id='%1' aria-describedby='%1_helpblock' %_>";

  protected function precode()
  {
    $this->attributes['val-email'] = true;
    $this->attributes['prepend-icon'] = "fas fa-envelope";
    parent::precode();
  }
}


class bpassword extends binput
{
  protected $inputcode = "<input type='password' name='%1' class='form-control %class' id='%1' aria-describedby='%1_helpblock' %_>";

  protected function precode () {
    parent::precode();
    $this->extraattributes['texttitle'] = $this->attributes[2];
  }
}


class bformsubmit extends \booosta\templateparser\Tag
{
  protected $html = "<button type='submit' class='btn btn-primary %align %class' %_>%buttontext</button>";
  protected $fixattr = ['align'];

  protected function precode()
  {
    if($this->attributes['align'] == "center"):
      $this->html = str_replace("%align", "d-block mx-auto", $this->html);
    else:
      $this->html = str_replace("%align", '', $this->html);
    endif;
  }
}

class bformgrpstart extends binput
{
  protected $html = "<div class='form-group'> <label class='col-sm-%size control-label'>%1</label> <div class='col-sm-%asize'>";

  protected function precode() {}  // do not inherit precode from binput
}


class bdate extends binput
{
  protected $inputcodesingle = "<input type='text' name='%1' value='%2' class='epb-datepicker form-control %class' id='%1' autocomplete='off' %_>";
  protected $inputcoderange = "<input type='text' name='%1' value='%2' class='epb-rangedatepicker form-control %class' id='%1' autocomplete='off' %_>";
  protected $inputcoderangewithranges = "<input type='text' name='%1' value='%2' class='epb-rangedatepicker-with-ranges form-control %class' id='%1' autocomplete='off' %_>";
  #protected $inputcodefullcontrol = "<input type='text' name='%1' value='%2' class='form-control %class' id='%1' %_>";
  protected $fixattr = ['showdropdowns','showweeknumbers','rangedatepicker','rangedatepickerwithranges'];

  protected function precode()
  {
    $lang = $this->config('language');
    if($lang && array_key_exists('date' . strtoupper($lang), $this->validator)) $this->attributes['val-date' . strtoupper($lang)] = true;
    else $this->attributes['val-date'] = true;

    $this->attributes['prepend-icon'] = "fas fa-calendar-alt";

    if($this->attributes['rangedatepicker']) $this->inputcode = $this->inputcoderange;
    elseif($this->attributes['rangedatepickerwithranges']) $this->inputcode = $this->inputcoderangewithranges;
    #elseif($this->attributes['rangedatepickerfullcontrol']) $this->inputcode = $this->inputcodefullcontrol;
    else $this->inputcode = $this->inputcodesingle;

    parent::precode();
    $this->default_save_data();

    // Fullcontrol datepicker wird mit #ID initialisiert... dh nicht 100mal auf der Seite verwenden!
    $js = "";
    $id = $this->attributes['1'];
    // if($this->attributes['rangedatepickerfullcontrol']):

    //   $js .= "var options = \$.extend( {}, datepicker_defaults ";
    //   if ($this->attributes['rangedatepicker']) $js .= ", datepicker_range";
    //   elseif ($this->attributes['rangedatepickerwithranges']) $js .= ", datepicker_ranges";
    //   $js .= ");";
    //   $js .= "\$('#$id').daterangepicker(options);";
      
    //   $js .= "\$('#$id').on('apply.daterangepicker', function(ev, picker) { \$(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY')); });";
    //   $js .= "\$('#$id').on('cancel.daterangepicker', function(ev, picker) { \$(this).val(''); });";

    // endif;
    if($this->attributes['showdropdowns']) $js .= "\$('#$id').data('daterangepicker').showDropdowns = true;\n";
    if($this->attributes['showweeknumbers']) $js .= "\$('#$id').data('daterangepicker').showISOWeekNumbers = true;\n";
    if($js != "") $this->add_extra_js($js);
  }
}


class bcheckbox extends binput
{
  protected $htmlhorizontal_checkbox = "<div class='form-group row'>
                                <div class='offset-sm-%form-horizontal-size col-sm-%asize'>
                                  <div class='custom-control custom-checkbox'>
                                    %inputcode
                                    <label for='%1' class='custom-control-label'>%texttitle</label>
                                    %varhelp
                                  </div>
                                </div>
                             </div>";

  protected $htmldefault_checkbox = "<div class='form-group'>
                              <div class='custom-control custom-checkbox'>
                                %inputcode
                                <label for='%1' class='custom-control-label'>%texttitle</label>
                                %varhelp
                              </div>
                            </div>";

  protected $fixattr = ['type'];
  protected $inputcode = "<input type='checkbox' name='%1' %2 class='custom-control-input %class' id='%1' %_>";
  protected $inputcodeswitch = "<input type='checkbox' name='%1' %2 class='form-control %class' id='%1' data-bootstrap-switch %_>";
  protected $default_req_message = 'Please check this box';

  protected function precode()
  {
    if($this->attributes['type'] == "switch"): 
      $this->inputcode = $this->inputcodeswitch;
      if(!$this->attributes['form-horizontal']): 
        $this->inputcode = "</br>". $this->inputcode;
      endif;
    else:
      $this->htmlhorizontal = $this->htmlhorizontal_checkbox;
      $this->htmldefault = $this->htmldefault_checkbox;
    endif;
    parent::precode();
    if($this->attributes[2]) $this->attributes[2] = 'checked'; else $this->attributes[2] = '';
    if($this->extraattributes['texttitle'] == '') $this->extraattributes['texttitle'] = $this->attributes[1];
    $this->err_required = $this->extraattributes['err-required'] ?? 'Please check this box';

    $this->default_save_data();
  }
}


class bstatic extends binput
{
  protected $inputcode = "<span class='form-control-plaintext %class' id='%2'>%1</span>";

  protected function precode() {
    parent::precode();
    $this->extraattributes['texttitle'] = $this->attributes[2];
  }  
}


class btextarea extends binput
{
  //cols machen bei bootstrap keinen Sinn das das input auf die gesamte laenge gezogen wird
  protected $inputcode = "<textarea name='%1' rows='%2' class='form-control %class' %_>%content</textarea>";

  protected function precode()
  {
    parent::precode();
    if($this->attributes[2] == '') $this->attributes[2] = '5';
    $this->attributes['texttitle'] = $this->attributes[3];
  }

  protected function postcode()
  {
    parent::postcode();
    $this->html = str_replace("%asize", 12-$this->extraattributes['size'], $this->html);
    $lines = explode("\n", $this->code);
    $headcode = array_shift($lines);
    $content = implode("\n", $lines);

    $this->html = str_replace("%content", $content, $this->html);
  }
}


class rtextarea extends btextarea
{
  protected $html = "<div class='form-group'>
                       <label for='%1' class='col-sm-%size control-label'>%textareatitle</label>
                       <div class='col-sm-%rasize'>
                         <textarea name='%1' cols='%2' rows='%3' class='form-control %class' %_>%content</textarea>
                       </div>
                     <div class='col-sm-%rsize brighttext'>";
}


class bselect extends binput
{
  protected $fixattr = ['type'];
  protected $inputcode = "<select name='%1' size='%3' class='form-control %class' %_>%options</select>";
  protected $inputcodesearch = "<select name='%1' size='%3' data-placeholder='Select a State' class='form-control epb-select2 %class' %_>%options</select>";
  protected $inputcodemultiple = "<select name='%1' size='%3' data-placeholder='%multiple-placeholder' multiple=multiple class='form-control epb-select2 %class' %_>%options</select>";

  protected function precode()
  {
    if($this->attributes['type'] == "search") $this->inputcode = $this->inputcodesearch;
    if($this->attributes['type'] == "multiple") $this->inputcode = $this->inputcodemultiple;
    parent::precode();
    
    $lines = explode("\n", $this->code);
    $headcode = array_shift($lines);  // variable not used, but array_shift necessary!
    $this->localvars['opts'] = '';

    foreach($lines as $line):
      $key = preg_replace("/.*\[([^\]]*)\].*/", "$1", $line);
      $val = preg_replace("/.*\](.*)/", "$1", $line);

      if($key == '') $key = $val;
      if($key == $this->attributes[2]) $sel = "selected"; else $sel = "";
      $this->localvars['opts'] .= "<option value='$key' $sel>$val</option>";
    endforeach;

    if($this->attributes[3] == '') $this->attributes[3] = '0';
  }

  protected function postcode()
  {
    parent::postcode();
    $this->html = str_replace("%options", $this->localvars['opts'], $this->html);
    $this->html = str_replace("%asize", 12-$this->extraattributes['size'], $this->html);
  }
}


class btimesel extends \booosta\templateparser\tags\timesel
{
  protected $html = "<div class='form-group'>
                       <label for='%1' class='col-sm-%size control-label'>%title</label>
                       <div class='col-sm-4'>
                         <select name='%1_hour' class='form-control epbtimesel %class' id='%1_hour'  %_>%hoptions</select> :
                         <select name='%1_minute' class='form-control epbtimesel %class' id='%1_minute' %_>%moptions</select>
                       </div>
                     </div>";
}


class btimesela extends btimesel
{
  protected $add_hoptions = '<option %hselected_A>A</option>';
  protected $add_moptions = '<option %mselected_A>A</option>';
}


class bboxcenter extends \booosta\templateparser\Tag
{
  protected $fixattr = ['boxsize'];
  protected $html = '<div class="row">
                       <div class="col-sm-%sizsm offset-sm-%asizsm col-md-%sizmd offset-md-%asizmd col-lg-%sizlg offset-lg-%asizlg col-xl-%sizxl offset-xl-%asizxl">';

  protected function postcode()
  {
    list($sizsm, $sizmd, $sizlg, $sizxl) = explode(",", $this->attributes['boxsize']);
    if($sizmd == "") $sizmd = $sizlg = $sizxl = $sizsm; 
    #\booosta\debug("$sizmd = $sizlg = $sizxl = $sizsm");

    $this->html = str_replace("%sizsm", $sizsm, $this->html); $this->html = str_replace("%asizsm", (12-$sizsm)/2, $this->html);
    $this->html = str_replace("%sizmd", $sizmd, $this->html); $this->html = str_replace("%asizmd", (12-$sizmd)/2, $this->html);
    $this->html = str_replace("%sizlg", $sizlg, $this->html); $this->html = str_replace("%asizlg", (12-$sizlg)/2, $this->html);
    $this->html = str_replace("%sizxl", $sizxl, $this->html); $this->html = str_replace("%asizxl", (12-$sizxl)/2, $this->html);
  }
}


class bcol extends \booosta\templateparser\Tag
{
  protected $fixattr = ['boxsize'];
  
  protected function precode()
  {
    if($this->attributes['boxsize']):
      list($sizsm, $sizmd, $sizlg, $sizxl) = explode(",", $this->attributes['boxsize']);
      if($sizmd == "") $sizmd = $sizlg = $sizxl = $sizsm; 

      $this->html = '<div class="col-sm-%sizsm col-md-%sizmd col-lg-%sizlg col-xl-%sizxl">';
      $this->html = str_replace("%sizsm", $sizsm, $this->html);
      $this->html = str_replace("%sizmd", $sizmd, $this->html);
      $this->html = str_replace("%sizlg", $sizlg, $this->html);
      $this->html = str_replace("%sizxl", $sizxl, $this->html);
    else:
      $this->html = '<div class="col-xl">';
    endif;
  }
}


class bpanel extends \booosta\templateparser\Tag
{
  protected $html = '<div class="card %panel-color %panel-style %class" %_>
                      <div class="card-header">
                        <h3 class="card-title">%ptitle</h3>
                        <div class="card-tools">
                          %plink %tools
                          %minimizebutton 
                        </div>
                      </div>
                    <div class="card-body">';

  protected $fixattr = ['paneltitle', 'panellink', 'panellinkicon', 'panellinktext', 'panel-color','no-minimize','panel-style'];

  protected function precode()
  {
    if($this->attributes['panel-color'] == "no-color"):
      $this->html = str_replace('%panel-color', '', $this->html);
    elseif($this->attributes['panel-color']):
      $this->html = str_replace('%panel-color', 'card-'.$this->attributes['panel-color'], $this->html);
    else:
      $this->html = str_replace('%panel-color', 'card-'.$this->defaultvars['panel-color'], $this->html);
    endif;

    if($this->attributes['panel-style'] == 'full') $this->html = str_replace('%panel-style', '', $this->html);
    elseif($this->attributes['panel-style'] == 'outline') $this->html = str_replace('%panel-style', 'card-outline', $this->html);
    else $this->html = str_replace('%panel-style', $this->defaultvars['panel-style'], $this->html);

    if($this->attributes['no-minimize']) $this->html = str_replace('%minimizebutton', '', $this->html);
    else $this->html = str_replace('%minimizebutton', '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>', $this->html);

    if($this->attributes['paneltitle']) $this->html = str_replace("%ptitle", $this->attributes['paneltitle'], $this->html);
    else $this->html = str_replace("%ptitle", '', $this->html);

    if($this->attributes['panellink']):
      $this->html = str_replace("%plink", "<a href='" . $this->attributes['panellink'] . "' class='btn btn-success btn-sm'><i class='fas fa-" .
             $this->attributes['panellinkicon'] . "'></i> " . $this->attributes['panellinktext'] . "</a>", $this->html);
    else:
      $this->html = str_replace("%plink", '', $this->html);
    endif;
  }
                
  protected function postcode()
  {
    // replace %tools with code from {BPANELTOOLS}
    $target_id = $this->extraattributes['id'] ?? $this->attributes[1] ?? 'bpanel0';
    $collected_html = $this->get_data('collected-html');
    if(is_array($collected_html)) $tools_html = $collected_html[$target_id]['tools'];

    if(is_array($tools_html)) $tools_html = implode('', $tools_html);
    $this->html = str_replace('%tools', $tools_html, $this->html);

    // remove collected html, so next bpanel is not using it
    unset($collected_html[$target_id]['tools']);
    $this->save_data('collected-html', $collected_html, false);
  }
}

// Accordeon bisher kaum genuetzt
// 
// class baccpanel extends \booosta\templateparser\Tag
// {
//   protected $html = '<div class="panel panel-default"><div class="panel-heading" role="tab" id="accheading-%1"><h4 class="panel-title">
//                        <a data-toggle="collapse" data-parent="#accordion-%2" href="#collapse-%1" aria-expanded="%expanded" class="%collapsed" aria-controls="collapse-%1">
//                        %3</a> </h4> </div> <div id="collapse-%1" class="panel-collapse collapse %in" role="tabpanel" aria-labelledby="accheading-%1">
//                      <div class="panel-body">';

//   protected function postcode()
//   {
//     if($this->attributes[4]):
//       $this->html = str_replace("%collapsed", "collapsed", $this->html); 
//       $this->html = str_replace("%in", "", $this->html); 
//       $this->html = str_replace("%expanded", "false", $this->html);
//     else: 
//       $this->html = str_replace("%collapsed", "", $this->html); 
//       $this->html = str_replace("%in", "in", $this->html); 
//       $this->html = str_replace("%expanded", "true", $this->html);
//     endif;
//   }
// }


class bformstart extends \booosta\templateparser\Tag
{
  protected $html = "<form method='post' class='form-horizontal' role='form' action='%1' %2 onSubmit='return checkForm();' %_>";

  protected function precode()
  {
    if($this->extraattributes['id'] == '') $this->extraattributes['id'] = 'form0';
    if($this->extraattributes['name'] == '') $this->extraattributes['name'] = $this->extraattributes['id'];

    $this->save_data('current-form', $this->extraattributes['id'], false);  // false = append

    $this->add_postfunction(
      function() {
        $formid = $this->extraattributes['id'];

        $js0 = "formvalidator_$formid = \$('#$formid').validate({ rules: {\n";
        $js1 = "}, messages: {\n";
        $js2 = "}, errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      if($(element).hasClass('inputfile')) {
        label = $(element).next('label');
        label.after(error);
      }else{
        element.closest('.form-group').append(error);
      }
    },
    highlight: function (element, errorClass, validClass) {
      if($(element).hasClass('inputfile')) {
        label = $(element).next('label');
        label.addClass('is-invalid');
      } else {
        $(element).addClass('is-invalid');
      }
    },
    unhighlight: function (element, errorClass, validClass) {
      if($(element).hasClass('inputfile')) {
        label = $(element).next('label');
        label.removeClass('is-invalid');
      } else {
        $(element).removeClass('is-invalid');
      }
    }
  });";

        $form_rules = $this->get_data('form-rules');
        $form_messages = $this->get_data('form-messages');

        $js = $js0 . $form_rules[$formid] . $js1 . $form_messages[$formid] . $js2;
        #$js = $js0 . $form_rules[$this->extraattributes['id']] . $js1 . $form_messages[$this->extraattributes['id']] . $js2;

        $code = $this->make_jquery_ready($js);
        return $this->replacement_code($code);
      }
    );
  }
}


class bformstartm extends bformstart
{
  protected $html = "<form method='post' enctype='multipart/form-data' class='form-horizontal' role='form' action='%1' %2 onSubmit='return checkForm();' %_>";
}


class bpanelfooter extends \booosta\templateparser\Tag
{
  protected function postcode()
  {
    $target_id = $this->extraattributes['bpanelid'] ?? $this->attributes[1] ?? 'bpanel0';
    $this->save_data('printout-mode', ['mode' => 'collect-html', 'target-id' => $target_id, 'target-unit' => 'footer'], false);  // false = append
  }
}


class bpanelfooterend extends \booosta\templateparser\Tag
{
  protected function precode()
  {
    $this->save_data('printout-mode', null, false);
  }
}


class bpaneltools extends \booosta\templateparser\Tag
{
  protected function postcode()
  {
    $target_id = $this->extraattributes['bpanelid'] ?? $this->attributes[1] ?? 'bpanel0';
    $this->save_data('printout-mode', ['mode' => 'collect-html', 'target-id' => $target_id, 'target-unit' => 'tools'], false);  // false = append
  }
}


class bpaneltoolsend extends \booosta\templateparser\Tag
{
  protected function precode()
  {
    $this->save_data('printout-mode', null, false);
  }
}


class bpanelend extends \booosta\templateparser\Tag
{
  protected $html = '</div>%footer</div>';

  protected function postcode()
  {
    $target_id = $this->extraattributes['bpanelid'] ?? $this->attributes[1] ?? 'bpanel0';
    $collected_html = $this->get_data('collected-html');
    if(is_array($collected_html)) $footer_html = $collected_html[$target_id]['footer'];

    if(is_array($footer_html)) $footer_html = implode('', $footer_html);
    if($footer_html) $footer_html = "<div class='card-footer'>$footer_html</div>";
    $this->html = str_replace('%footer', $footer_html, $this->html);

    // remove collected html, so next bpanel is not using it
    unset($collected_html[$target_id]['footer']);
    $this->save_data('collected-html', $collected_html, false);
  }
}


class biban extends btext
{
  protected function precode()
  {
    parent::precode();
    $this->add_extra_js("$('#{$this->attributes[1]}').mask('SS00 0000 0000 0000 0000 00', { placeholder: '____ ____ ____ ____ ____ __' });");
    $this->extraattributes['style'] = "text-transform: uppercase;";
  }
}
