<?php

require_once 'extend_summary_fields.civix.php';
// phpcs:disable
use CRM_ExtendSummaryFields_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function extend_summary_fields_civicrm_config(&$config)
{
    _extend_summary_fields_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function extend_summary_fields_civicrm_xmlMenu(&$files)
{
    _extend_summary_fields_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function extend_summary_fields_civicrm_install()
{
    _extend_summary_fields_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function extend_summary_fields_civicrm_postInstall()
{
    _extend_summary_fields_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function extend_summary_fields_civicrm_uninstall()
{
    _extend_summary_fields_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function extend_summary_fields_civicrm_enable()
{
    _extend_summary_fields_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function extend_summary_fields_civicrm_disable()
{
    _extend_summary_fields_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function extend_summary_fields_civicrm_upgrade($op, CRM_Queue_Queue $queue = null)
{
    return _extend_summary_fields_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function extend_summary_fields_civicrm_managed(&$entities)
{
    _extend_summary_fields_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function extend_summary_fields_civicrm_caseTypes(&$caseTypes)
{
    _extend_summary_fields_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function extend_summary_fields_civicrm_angularModules(&$angularModules)
{
    _extend_summary_fields_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function extend_summary_fields_civicrm_alterSettingsFolders(&$metaDataFolders = null)
{
    _extend_summary_fields_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function extend_summary_fields_civicrm_entityTypes(&$entityTypes)
{
    _extend_summary_fields_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function extend_summary_fields_civicrm_themes(&$themes)
{
    _extend_summary_fields_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function extend_summary_fields_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function extend_summary_fields_civicrm_navigationMenu(&$menu) {
//  _extend_summary_fields_civix_insert_navigation_menu($menu, 'Mailings', array(
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ));
//  _extend_summary_fields_civix_navigationMenu($menu);
//}

// The functions below are implemented by me.
/**
 * Implements hook_civicrm_sumfields_definitions()
 */
function extend_summary_fields_civicrm_sumfields_definitions(&$custom)
{
    CRM_ExtendSummaryFields_Service::sumfieldsDefinition($custom);
}
/**
 * Implements hook_civicrm_buildForm().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_buildForm
 */
function extend_summary_fields_civicrm_buildForm($formName, &$form)
{
    CRM_ExtendSummaryFields_Service::buildForm($formName, $form);
}
/**
 * Implements hook_civicrm_postProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postProcess
 */
function extend_summary_fields_civicrm_postProcess($formName, &$form)
{
    CRM_ExtendSummaryFields_Service::postProcess($formName, $form);
}
