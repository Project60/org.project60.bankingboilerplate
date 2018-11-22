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

use CRM_Banking_ExtensionUtil as E;

/**
 * Boilerplate PostProcessor - copy to create your own!
 *
 * PostProcessors are run AFTER a transactions has been reconciled
 */
class CRM_Banking_PluginImpl_PostProcessor_MyPostProcessor extends CRM_Banking_PluginModel_PostProcessor {

  /**
   * class constructor - is called by the engine.
   */
  function __construct($config_name) {
    parent::__construct($config_name);

    /*
     * $config contains the parsed json configuration of this plugin (object)
     *
     * use the pattern below to initialise default values for the ones that
     *  are not provided by the configuration
     */
    $config = $this->_plugin_config;
    if (!isset($config->myparameter))       $config->myparameter = NULL;
    if (!isset($config->other_param))       $config->other_param = TRUE;
    if (!isset($config->third_param))       $config->third_param = [1,2,3];
  }

  /**
   * Should this postprocessor spring into action?
   * Evaluates the common 'required' fields in the configuration
   *
   * @param $match    CRM_Banking_Matcher_Suggestion   the executed match
   * @param $matcher  CRM_Banking_PluginModel_Matcher  the related transaction
   * @param $context  CRM_Banking_Matcher_Context      the matcher context contains cache data and context information
   *
   * @return bool     should the this postprocessor be activated
   */
  protected function shouldExecute(CRM_Banking_Matcher_Suggestion $match, CRM_Banking_PluginModel_Matcher $matcher, CRM_Banking_Matcher_Context $context) {

    /*
      This is the part where you should check whether the postprocessor
      should run now. It is called after *every* reconciliation (booking),
      so here you have...
       - the plugin's configuration
       - the contribution(s) linked to this transaction (if any)
       - the contact involved (if any)
       - the memberships involved (if any)

     ... to find out whether you should "sprint into action"

     You can also rely on parent::shouldExecute for some generic checks (e.g. for transaction status: processed/ignored)
    */

    // potential variables:
    $config        = $this->_plugin_config;
    $transaction   = $context->btx;
    $contributions = $this->getContributions($context);
    $contact       = $this->getSoleContact($context);
    $memberships   = $this->getMemberships($context);

    // don't hesitate to log WHY you're not executing, that will make it a lot easier to debug the process
    $this->logMessage("Not in the mood!", 'debug');
    
    // pass on to parent to check generic reasons
    return parent::shouldExecute($match, $matcher, $context);
  }


  /**
   * RUN the postprocessor
   *
   * At this point it has already been decided, that this should be executed - go for it!
   *
   * @param $match    CRM_Banking_Matcher_Suggestion   the executed match
   * @param $matcher  CRM_Banking_PluginModel_Matcher  the related transaction
   * @param $context  CRM_Banking_Matcher_Context      the matcher context contains cache data and context information
   *
   */
  public function processExecutedMatch(CRM_Banking_Matcher_Suggestion $match, CRM_Banking_PluginModel_Matcher $matcher, CRM_Banking_Matcher_Context $context) {
    if ($this->shouldExecute($match, $matcher, $context)) {
      // potential variables:
      $config        = $this->_plugin_config;
      $transaction   = $context->btx;
      $contributions = $this->getContributions($context);
      $contact       = $this->getSoleContact($context);
      $memberships   = $this->getMemberships($context);


      // PERFORM YOUR ACTIONS
      // -- HERE --

      // ...also don't forget to log what you're doing:
      $this->logMessage("What am I doing here?", 'debug');
    }
  }
}

