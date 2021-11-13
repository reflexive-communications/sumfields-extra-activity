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
function extend_summary_fields_civicrm_config(&$config) {
  _extend_summary_fields_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function extend_summary_fields_civicrm_xmlMenu(&$files) {
  _extend_summary_fields_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function extend_summary_fields_civicrm_install() {
  _extend_summary_fields_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function extend_summary_fields_civicrm_postInstall() {
  _extend_summary_fields_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function extend_summary_fields_civicrm_uninstall() {
  _extend_summary_fields_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function extend_summary_fields_civicrm_enable() {
  _extend_summary_fields_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function extend_summary_fields_civicrm_disable() {
  _extend_summary_fields_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function extend_summary_fields_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
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
function extend_summary_fields_civicrm_managed(&$entities) {
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
function extend_summary_fields_civicrm_caseTypes(&$caseTypes) {
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
function extend_summary_fields_civicrm_angularModules(&$angularModules) {
  _extend_summary_fields_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function extend_summary_fields_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _extend_summary_fields_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function extend_summary_fields_civicrm_entityTypes(&$entityTypes) {
  _extend_summary_fields_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function extend_summary_fields_civicrm_themes(&$themes) {
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

/**
 * Implements hook_civicrm_sumfields_definitions()
 *
 * Change "mycustom" to the name of your own extension.
 */
function extend_summary_fields_civicrm_sumfields_definitions(&$custom) {
    $days = ['30', '60', '90', '180', '365', '730'];
    foreach ($days as $day) {
        $custom['fields']['number_of_activities_'.$day] = [
            // Choose which group you want this field to appear with.
            'optgroup' => 'extend_summary_fields', // could just add this to the existing "fundraising" optgroup
            'label' => 'The number of activities in the last '.$day.' days',
            'data_type' => 'Integer',
            'html_type' => 'Text',
            'weight' => '15',
            'text_length' => '32',
            // A change in the "trigger_table" should cause the field to be re-calculated.
            'trigger_table' => 'civicrm_activity_contact',
            // A parentheses enclosed SQL statement with a function to ensure a single
            // value is returned. The value should be restricted to a single
            // contact_id using the NEW.contact_id field
            'trigger_sql' => _rewrite_sql('(
                SELECT COALESCE(COUNT(1), 0)
                FROM civicrm_activity_contact ac
                LEFT JOIN civicrm_activity a ON a.id = ac.activity_id
                WHERE ac.contact_id = NEW.contact_id
                AND ac.record_type_id = %extend_summary_fields_record_type_id
                AND a.activity_type_id IN (%extend_summary_fields_activity_type_ids)
                AND a.status_id IN (%extend_summary_fields_activity_status_ids)
                AND a.activity_date_time >= DATE_SUB(CURDATE(), INTERVAL '.$day.' DAY)
            )'),
        ];
    }
    // If we don't want to add our fields to the existing optgroups or fieldsets on the admin form,
    // we can make new ones
    $custom['optgroups']['extend_summary_fields'] = [
        'title' => 'Number of activities',
        'fieldset' => 'Activities', // Could add this to an existing fieldset by naming it here
        'component' => 'CiviCampaign',
    ];
}
function extend_summary_fields_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Sumfields_Form_SumFields') {
    $tpl = CRM_Core_Smarty::singleton();
    $fieldsets = $tpl->_tpl_vars['fieldsets'];

    // Get jsumfields definitions, because we need the fieldset names as a target
    // for where to insert our option fields
    $custom = [];
    extend_summary_fields_civicrm_sumfields_definitions($custom);

    // Create a field for Financial Types on related contributions.
    $label = E::ts('Activity Types');
    $form->add('select', 'extend_summary_fields_activity_type_ids', $label, CRM_Activity_BAO_Activity::buildOptions('activity_type_id', 'get'), false, ['multiple' => true, 'class' => 'crm-select2 huge']);
    $form->add('select', 'extend_summary_fields_activity_status_ids', $label, CRM_Activity_BAO_Activity::buildOptions('activity_status_id', 'get'), false, ['multiple' => true, 'class' => 'crm-select2 huge']);
    $form->add('select', 'extend_summary_fields_record_type_id', $label, CRM_Activity_BAO_ActivityContact::buildOptions('record_type_id', 'get'), false, ['multiple' => false, 'class' => 'crm-select2 huge']);
    $fieldsets[$custom['optgroups']['extend_summary_fields']['fieldset']]['extend_summary_fields_activity_type_ids'] = E::ts('Activity types to be used when calculating activity summary fields.');
    $fieldsets[$custom['optgroups']['extend_summary_fields']['fieldset']]['extend_summary_fields_activity_status_ids'] = E::ts('Activity statuses to be used when calculating activity summary fields.');
    $fieldsets[$custom['optgroups']['extend_summary_fields']['fieldset']]['extend_summary_fields_record_type_id'] = E::ts('Recory type to be used when calculating activity summary fields.');
    // Set defaults.
    $form->setDefaults([
        'extend_summary_fields_activity_type_ids' => sumfields_get_setting('extend_summary_fields_activity_type_ids'),
        'extend_summary_fields_activity_status_ids' => sumfields_get_setting('extend_summary_fields_activity_status_ids'),
        'extend_summary_fields_record_type_id' => sumfields_get_setting('extend_summary_fields_record_type_id'),
    ]);

    $form->assign('fieldsets', $fieldsets);
  }
}
/**
 * Implements hook_civicrm_postProcess().
 */
function extend_summary_fields_civicrm_postProcess($formName, &$form) {
    if ($formName == 'CRM_Sumfields_Form_SumFields') {
        // Save option fields as submitted.
        sumfields_save_setting('extend_summary_fields_activity_type_ids', CRM_Utils_Array::value('extend_summary_fields_activity_type_ids', $form->_submitValues));
        sumfields_save_setting('extend_summary_fields_activity_status_ids', CRM_Utils_Array::value('extend_summary_fields_activity_status_ids', $form->_submitValues));
        sumfields_save_setting('extend_summary_fields_record_type_id', CRM_Utils_Array::value('extend_summary_fields_record_type_id', $form->_submitValues));

        if ($form->_submitValues['when_to_apply_change'] == 'on_submit') {
            $returnValues = [];
            sumfields_gen_data($returnValues);
        }
    }
}

/**
 * Replace jsumfields %variables with the appropriate values. NOTE: this function
 * does NOT call jsumfields_sql_rewrite().
 *
 * @return string Modified $sql.
 */
function _rewrite_sql($sql) {
    // Note: most of these token replacements fill in a sql IN statement,
    // e.g. field_name IN (%token). That means if the token is empty, we
    // get a SQL error. So... for each of these, if the token is empty,
    // we fill it with all possible values at the moment. If a new option
    // is added, summary fields will have to be re-configured.

    $ids = sumfields_get_setting('extend_summary_fields_activity_type_ids', []);
    if (count($ids) == 0) {
        $ids = array_keys(CRM_Activity_BAO_Activity::buildOptions('activity_type_id', 'get'));
    }
    $str_ids = implode(',', $ids);
    $sql = str_replace('%extend_summary_fields_activity_type_ids', $str_ids, $sql);

    $ids = sumfields_get_setting('extend_summary_fields_activity_status_ids', []);
    if (count($ids) == 0) {
        $ids = array_keys(CRM_Activity_BAO_Activity::buildOptions('activity_status_id', 'get'));
    }
    $str_ids = implode(',', $ids);
    $sql = str_replace('%extend_summary_fields_activity_status_ids', $str_ids, $sql);

    $ids = sumfields_get_setting('extend_summary_fields_record_type_id', []);
    if (count($ids) == 0) {
        $ids = ['2'];
    }
    $sql = str_replace('%extend_summary_fields_record_type_id', $ids[0], $sql);

    return $sql;
}
