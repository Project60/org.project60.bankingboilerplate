<?php
/*-------------------------------------------------------+
| Project 60 - CiviBanking                               |
| Copyright (C) 2018 SYSTOPIA                            |
| Author: B. Endres (endres -at- systopia.de)            |
| http://www.systopia.de/                                |
+--------------------------------------------------------+
| This program is released as free software under the    |
| Affero GPL v3 license. You can redistribute it and/or  |
| modify it under the terms of this license which you    |
| can read by viewing the included agpl.txt or online    |
| at www.gnu.org/licenses/agpl.html. Removal of this     |
| copyright header is strictly prohibited without        |
| written permission from the original author(s).        |
+--------------------------------------------------------*/

use CRM_Bankingboilerplate_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Bankingboilerplate_Upgrader extends CRM_Bankingboilerplate_Upgrader_Base {

  /**
   * Make sure our module's in the list
   */
  public function enable() {
    // make sure our new plugins are registered
    $this->registerPlugin('postprocessor_boilerplate', 'Boilerplate PostProcessor', 'CRM_Banking_PluginImpl_PostProcessor_MyPostProcessor');
  }


  /**
   * Helper functions for plugin registration
   */
  protected function registerPlugin($name, $label, $value) {
    // first: see if it's there already
    $plugins = civicrm_api3('OptionValue', 'get', [
        'option_group_id' => 'civicrm_banking.plugin_types',
        'name'            => $name
    ]);

    if ($plugins['count'] == 1) {
      // already there, nothing to do
    } elseif ($plugins['count'] == 0) {
      // not there: create entry!
      $plugin = civicrm_api3('OptionValue', 'create', [
          'option_group_id' => 'civicrm_banking.plugin_types',
          'name'            => $name,
          'label'           => $label,
          'value'           => $value
      ]);
    } else {
      // there's multiple ones... that can't be good:
      throw new Exception("Name '{$name}' used multiple times in option group 'civicrm_banking.plugin_types'!");
    }
  }
}
