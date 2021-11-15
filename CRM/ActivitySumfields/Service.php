<?php

use CRM_ActivitySumfields_ExtensionUtil as E;

class CRM_ActivitySumfields_Service
{
    const MULTIPLE_OPTIONS = ['multiple' => true, 'class' => 'crm-select2 huge'];
    const SINGLE_OPTIONS = ['multiple' => false, 'class' => 'crm-select2 huge'];
    /**
     * This function extends the sumfield definition list with
     * our ones. Number of activities in the last
     * 30, 60, 90, 180, 365, 730 days.
     */
    public static function sumfieldsDefinition(&$custom)
    {
        $days = ['30', '60', '90', '180', '365', '730'];
        foreach ($days as $day) {
            $custom['fields']['number_of_activities_'.$day] = [
                'optgroup' => 'activity_sumfields',
                'label' => 'The number of activities in the last '.$day.' days',
                'data_type' => 'Integer',
                'html_type' => 'Text',
                'weight' => '15',
                'text_length' => '32',
                'trigger_table' => 'civicrm_activity_contact',
                'trigger_sql' => self::rewriteSql('(
                    SELECT COALESCE(COUNT(1), 0)
                    FROM civicrm_activity_contact ac
                    LEFT JOIN civicrm_activity a ON a.id = ac.activity_id
                    WHERE ac.contact_id = NEW.contact_id
                    AND ac.record_type_id = %activity_sumfields_record_type_id
                    AND a.activity_type_id IN (%activity_sumfields_activity_type_ids)
                    AND a.status_id IN (%activity_sumfields_activity_status_ids)
                    AND a.activity_date_time >= DATE_SUB(CURDATE(), INTERVAL '.$day.' DAY)
                )'),
            ];
        }
        // Add new optgroup that will contain the setting parameters for the activities
        $custom['optgroups']['activity_sumfields'] = [
            'title' => 'Number of activities',
            'fieldset' => 'Activities',
        ];
    }
    public static function buildForm($formName, &$form)
    {
        if ($formName !== 'CRM_Sumfields_Form_SumFields') {
            return;
        }
        $settings = new CRM_ActivitySumfields_Config(E::LONG_NAME);
        $labels = [
            'activity-type' => E::ts('Activity Types'),
            'activity-type-desc' => E::ts('Activity types to be used when calculating activity summary fields.'),
            'activity-status' => E::ts('Activity Statuses'),
            'activity-status-desc' => E::ts('Activity statuses to be used when calculating activity summary fields.'),
            'contact-record-type' => E::ts('Contact Record Type'),
            'contact-record-type-desc' => E::ts('Recory type to be used when calculating activity summary fields.'),
        ];
        $tpl = CRM_Core_Smarty::singleton();
        $fieldsets = $tpl->_tpl_vars['fieldsets'];

        // Get definitions, because we need the fieldset names as a target
        // for where to insert our option fields
        $custom = [];
        self::sumfieldsDefinition($custom);

        // Create a field for Financial Types on related contributions.
        $form->add('select', 'activity_sumfields_activity_type_ids', $labels['activity-type'], CRM_Activity_BAO_Activity::buildOptions('activity_type_id', 'get'), false, self::MULTIPLE_OPTIONS);
        $form->add('select', 'activity_sumfields_activity_status_ids', $labels['activity-status'], CRM_Activity_BAO_Activity::buildOptions('activity_status_id', 'get'), false, self::MULTIPLE_OPTIONS);
        $form->add('select', 'activity_sumfields_record_type_id', $labels['contact-record-type'], CRM_Activity_BAO_ActivityContact::buildOptions('record_type_id', 'get'), false, self::SINGLE_OPTIONS);
        $fieldsets[$custom['optgroups']['activity_sumfields']['fieldset']]['activity_sumfields_activity_type_ids'] = $labels['activity-type-desc'];
        $fieldsets[$custom['optgroups']['activity_sumfields']['fieldset']]['activity_sumfields_activity_status_ids'] = $labels['activity-status-desc'];
        $fieldsets[$custom['optgroups']['activity_sumfields']['fieldset']]['activity_sumfields_record_type_id'] = $labels['contact-record-type-desc'];
        // Set defaults.
        $form->setDefaults([
            'activity_sumfields_activity_type_ids' => $settings->getSetting('activity_sumfields_activity_type_ids'),
            'activity_sumfields_activity_status_ids' => $settings->getSetting('activity_sumfields_activity_status_ids'),
            'activity_sumfields_record_type_id' => $settings->getSetting('activity_sumfields_record_type_id'),
        ]);

        $form->assign('fieldsets', $fieldsets);
    }
    /**
     * This function handles the save process of the activity config.
     *
     * @param string $formName
     * @param $form
     */
    public static function postProcess($formName, &$form)
    {
        if ($formName == 'CRM_Sumfields_Form_SumFields') {
            // Save option fields as submitted.
            $settings = new CRM_ActivitySumfields_Config(E::LONG_NAME);
            $settings->updateSetting('activity_sumfields_activity_type_ids', CRM_Utils_Array::value('activity_sumfields_activity_type_ids', $form->_submitValues));
            $settings->updateSetting('activity_sumfields_activity_status_ids', CRM_Utils_Array::value('activity_sumfields_activity_status_ids', $form->_submitValues));
            // As the record type id is a single select, the string value is returned not an array.
            $settings->updateSetting('activity_sumfields_record_type_id', [CRM_Utils_Array::value('activity_sumfields_record_type_id', $form->_submitValues)]);

            if ($form->_submitValues['when_to_apply_change'] == 'on_submit') {
                $returnValues = [];
                sumfields_gen_data($returnValues);
            }
        }
    }

    /**
     * Replace extend summary field %variables with the appropriate values.
     *
     * @return string Modified $sql.
     */
    private static function rewriteSql($sql): string
    {
        $settings = new CRM_ActivitySumfields_Config(E::LONG_NAME);
        // Note: most of these token replacements fill in a sql IN statement,
        // e.g. field_name IN (%token). That means if the token is empty, we
        // get a SQL error. So... for each of these, if the token is empty,
        // we fill it with all possible values at the moment. If a new option
        // is added, summary fields will have to be re-configured.

        $ids = $settings->getSetting('activity_sumfields_activity_type_ids');
        if (count($ids) == 0) {
            $ids = array_keys(CRM_Activity_BAO_Activity::buildOptions('activity_type_id', 'get'));
        }
        $str_ids = implode(',', $ids);
        $sql = str_replace('%activity_sumfields_activity_type_ids', $str_ids, $sql);

        $ids = $settings->getSetting('activity_sumfields_activity_status_ids');
        if (count($ids) == 0) {
            $ids = array_keys(CRM_Activity_BAO_Activity::buildOptions('activity_status_id', 'get'));
        }
        $str_ids = implode(',', $ids);
        $sql = str_replace('%activity_sumfields_activity_status_ids', $str_ids, $sql);

        $ids = $settings->getSetting('activity_sumfields_record_type_id');
        if (count($ids) == 0) {
            $ids = ['2'];
        }
        $sql = str_replace('%activity_sumfields_record_type_id', $ids[0], $sql);

        return $sql;
    }
}
