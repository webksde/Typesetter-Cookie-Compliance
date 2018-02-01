<?php

defined('is_running') or die('Not an entry point...');

class Admin_CookieCompliance {

  // Default Values
  var $button_color       = 'ffffff';
  var $button_text_color  = '000000';
  var $background_color   = '000000';
  var $text_color         = 'ffffff';
  var $header_text        = 'Diese Webseite verwendet Cookies';
  var $text               = 'Wir verwenden Cookies, um Inhalte und Anzeigen zu personalisieren, Funktionen für soziale Medien anbieten zu können und die Zugriffe auf unsere Website zu analysieren. Außerdem geben wir Informationen zu Ihrer Verwendung unserer Website an unsere Partner und soziale Medien, Werbung & Analysen weiter. Unsere Partner führen diese Informationen möglicherweise mit weiteren Daten zusammen, die Sie ihnen bereitgestellt haben oder die sie im Rahmen Ihrer Nutzung der Dienste gesammelt haben.';
  var $agree_button_text  = 'Cookies zulassen';
  var $policy_button_text = 'Details zeigen';
  var $policy_url         = '/datenschutz';


  function __construct() {
    $this->loadConfig();

    $cmd = common::GetCommand();

    switch ($cmd) {
      case 'saveConfig':
        $this->saveConfig();
        break;
    }
    $this->showForm();
  }

  function showForm() {
    global $langmessage;
    echo '<h1>EU Cookie Compliance</h1>';

    echo '<form action="' . common::GetUrl('Admin_CookieCompliance') . '" method="post">';

    echo '<p>Set up your cookie compliance message below.</p>';

    echo '<div><label>Button Background Color (Hex):</label><input type="text" name="button_color" placeholder="000000" maxlength="6" value="' . htmlspecialchars($this->button_color) . '" class="gpinput" style="width:200px" /></div>';
    echo '<div><label>Button Text Color (Hex):</label><input type="text" name="button_text_color" placeholder="000000" maxlength="6" value="' . htmlspecialchars($this->button_text_color) . '" class="gpinput" style="width:200px" /></div>';
    echo '<div><label>Background Color (Hex):</label><input type="text" name="background_color" placeholder="000000" maxlength="6" value="' . htmlspecialchars($this->background_color) . '" class="gpinput" style="width:200px" /></div>';
    echo '<div><label>Text Color (Hex):</label><input type="text" name="text_color" placeholder="000000" maxlength="6" value="' . htmlspecialchars($this->text_color) . '" class="gpinput" style="width:200px" /></div>';
    echo '<div><label>Header Text:</label><input type="text" name="header_text" value="' . htmlspecialchars($this->header_text) . '" class="gpinput" style="width:200px" /></div>';
    echo '<div><label>Text:</label><input type="text" name="text" value="' . htmlspecialchars($this->text) . '" class="gpinput" style="width:200px" /></div>';
    echo '<div><label>Agree Button Text:</label><input type="text" name="agree_button_text" value="' . htmlspecialchars($this->agree_button_text) . '" class="gpinput" style="width:200px" /></div>';
    echo '<div><label>Policy Button Text:</label><input type="text" name="policy_button_text" value="' . htmlspecialchars($this->policy_button_text) . '" class="gpinput" style="width:200px" /></div>';
    echo '<div><label>Policy URL (relative or full):</label><input type="text" name="policy_url" value="' . htmlspecialchars($this->policy_url) . '" class="gpinput" style="width:200px" /></div>';

    echo '<input type="hidden" name="cmd" value="saveConfig" />';

    echo '<input type="submit" value="' . htmlspecialchars($langmessage['save_changes']) . '" class="gpsubmit" style="margin-top:2em; "/>';
    echo '</form>';
  }

  function saveConfig() {
    global $addonPathData, $langmessage;

    $configFile = $addonPathData . '/config.php';
    $config = array();


    $config['button_color'] = $_POST['button_color'];
    $config['button_text_color'] = $_POST['button_text_color'];
    $config['background_color'] = $_POST['background_color'];
    $config['text_color'] = $_POST['text_color'];
    $config['header_text'] = $_POST['header_text'];
    $config['text'] = $_POST['text'];
    $config['agree_button_text'] = $_POST['agree_button_text'];
    $config['policy_button_text'] = $_POST['policy_button_text'];
    $config['policy_url'] = $_POST['policy_url'];

    $this->button_color = $config['button_color'];
    $this->button_text_color = $config['button_text_color'];
    $this->background_color = $config['background_color'];
    $this->text_color = $config['text_color'];
    $this->header_text = $config['header_text'];
    $this->text = $config['text'];
    $this->agree_button_text = $config['agree_button_text'];
    $this->policy_button_text = $config['policy_button_text'];
    $this->policy_url = $config['policy_url'];

    if (!gpFiles::SaveArray($configFile, 'config', $config)) {
      message($langmessage['OOPS']);
      return false;
    }

    message($langmessage['SAVED']);
    return true;
  }

  function loadConfig() {
    global $addonPathData;
    $configFile = $addonPathData . '/config.php';
    include_once $configFile;

    if (isset($config)) {
      $this->button_color = $config['button_color'];
      $this->button_text_color = $config['button_text_color'];
      $this->background_color = $config['background_color'];
      $this->text_color = $config['text_color'];
      $this->header_text = $config['header_text'];
      $this->text = $config['text'];
      $this->agree_button_text = $config['agree_button_text'];
      $this->policy_button_text = $config['policy_button_text'];
      $this->policy_url = $config['policy_url'];
    }
  }

}
