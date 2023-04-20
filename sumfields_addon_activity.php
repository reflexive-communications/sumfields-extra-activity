<?php

use Civi\SumfieldsExtraActivity\Service;

require_once 'sumfields_addon_activity.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function sumfields_addon_activity_civicrm_config(&$config): void
{
    _sumfields_addon_activity_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_sumfields_definitions()
 */
function sumfields_addon_activity_civicrm_sumfields_definitions(&$custom): void
{
    Service::sumfieldsDefinition($custom);
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_buildForm
 */
function sumfields_addon_activity_civicrm_buildForm($formName, &$form): void
{
    Service::buildForm($formName, $form);
}

/**
 * Implements hook_civicrm_postProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postProcess
 */
function sumfields_addon_activity_civicrm_postProcess($formName, &$form): void
{
    Service::postProcess($formName, $form);
}
