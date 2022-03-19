<?php

require_once 'sumfields_addon_activity.civix.php';

// phpcs:disable
use CRM_SumfieldsAddonActivity_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function sumfields_addon_activity_civicrm_config(&$config)
{
    _sumfields_addon_activity_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function sumfields_addon_activity_civicrm_xmlMenu(&$files)
{
    _sumfields_addon_activity_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function sumfields_addon_activity_civicrm_install()
{
    _sumfields_addon_activity_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function sumfields_addon_activity_civicrm_postInstall()
{
    _sumfields_addon_activity_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function sumfields_addon_activity_civicrm_uninstall()
{
    _sumfields_addon_activity_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function sumfields_addon_activity_civicrm_enable()
{
    _sumfields_addon_activity_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function sumfields_addon_activity_civicrm_disable()
{
    _sumfields_addon_activity_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function sumfields_addon_activity_civicrm_upgrade($op, CRM_Queue_Queue $queue = null)
{
    return _sumfields_addon_activity_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function sumfields_addon_activity_civicrm_managed(&$entities)
{
    _sumfields_addon_activity_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Add CiviCase types provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function sumfields_addon_activity_civicrm_caseTypes(&$caseTypes)
{
    _sumfields_addon_activity_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Add Angular modules provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function sumfields_addon_activity_civicrm_angularModules(&$angularModules)
{
    // Auto-add module files from ./ang/*.ang.php
    _sumfields_addon_activity_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function sumfields_addon_activity_civicrm_alterSettingsFolders(&$metaDataFolders = null)
{
    _sumfields_addon_activity_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function sumfields_addon_activity_civicrm_entityTypes(&$entityTypes)
{
    _sumfields_addon_activity_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function sumfields_addon_activity_civicrm_themes(&$themes)
{
    _sumfields_addon_activity_civix_civicrm_themes($themes);
}

// The functions below are implemented by us

/**
 * Implements hook_civicrm_sumfields_definitions()
 */
function sumfields_addon_activity_civicrm_sumfields_definitions(&$custom)
{
    CRM_ActivitySumfields_Service::sumfieldsDefinition($custom);
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_buildForm
 */
function sumfields_addon_activity_civicrm_buildForm($formName, &$form)
{
    CRM_ActivitySumfields_Service::buildForm($formName, $form);
}

/**
 * Implements hook_civicrm_postProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postProcess
 */
function sumfields_addon_activity_civicrm_postProcess($formName, &$form)
{
    CRM_ActivitySumfields_Service::postProcess($formName, $form);
}
