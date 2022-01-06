<?php

use CRM_ActivitySumfields_ExtensionUtil as E;

use Civi\Api4\Activity;
use Civi\Api4\Contact;
use Civi\Api4\CustomField;

/**
 * Testcases for the definitions.
 *
 * @group headless
 */
class CRM_ActivitySumfields_DefinitionTest extends CRM_ActivitySumfields_HeadlessBase
{
    public function setUpHeadless()
    {
    }
    /**
     * Create contact
     *
     * @return int Contact ID
     *
     * @throws \API_Exception
     * @throws \Civi\API\Exception\UnauthorizedException
     */
    private function createContact(): int
    {
        $result = Contact::create()
            ->addValue('contact_type', 'Individual')
            ->execute();
        self::assertCount(1, $result, 'Failed to create contact');
        $contact = $result->first();
        self::assertArrayHasKey('id', $contact, 'Contact ID not found');
        return (int)$contact['id'];
    }

    /**
     * Get custom field value
     *
     * @param int $entityId Entity ID
     * @param string $customFieldLabel Custom field label
     *
     * @return mixed Raw field value
     *
     * @throws \API_Exception
     * @throws \CiviCRM_API3_Exception
     * @throws \Civi\API\Exception\UnauthorizedException
     */
    private function getCustomFieldValue(int $entityId, string $customFieldLabel)
    {
        // Get custom field ID from label
        $result = CustomField::get()
            ->addSelect('id')
            ->addWhere('label', '=', $customFieldLabel)
            ->setLimit(1)
            ->execute();
        self::assertCount(1, $result, 'Failed to find custom field');
        $customFieldId = $result->first()['id'];

        // Get field value
        $result = civicrm_api3('CustomValue', 'getdisplayvalue', [
            'entity_id' => $entityId,
            'custom_field_id' => $customFieldId,
        ]);
        self::assertCount(1, $result['values'], 'Failed to find custom field value');
        return (array_shift($result['values']))['raw'];
    }

    /**
     * Enable individual summary fields
     *
     * @param array $fields List of fields to enable
     */
    private function enableSummaryField(array $fields)
    {
        // Save fields
        sumfields_save_setting('new_active_fields', $fields);

        // Regenerate fields
        $results = [];
        sumfields_save_setting('generate_schema_and_data', 'scheduled:'.date('Y-m-d H:i:s'));
        self::assertTrue(sumfields_gen_data($results), 'Failed to generate data');

        self::assertCount(1, $results);
        self::assertStringContainsString('New Status: success', $results[0], 'Failed to enable summary field');
    }

    /**
     * Add an activity to a contact. The contact will be set as
     * source and target.
     *
     * @param int $contactId as source and target.
     */
    private function addActivity(int $contactId, int $activityTypeId)
    {
        $result = Activity::create(false)
            ->addValue('activity_type_id', $activityTypeId)
            ->addValue('source_contact_id', $contactId)
            ->addValue('target_contact_id', $contactId)
            ->addValue('status_id:name', 'Completed')
            ->execute();
        self::assertCount(1, $result, 'Failed to create activity');
        $activity = $result->first();
        self::assertArrayHasKey('id', $activity, 'activity ID not found');
        return (int)$activity['id'];
    }
    public function hook_civicrm_sumfields_definitions(&$custom)
    {
        CRM_ActivitySumfields_Service::sumfieldsDefinition($custom);
    }

    /**
     * @throws \API_Exception
     * @throws \CiviCRM_API3_Exception
     * @throws \Civi\API\Exception\UnauthorizedException
     */
    public function testNumberOfActivitiesInLastIntervals()
    {
        $settings = new CRM_ActivitySumfields_Config(E::LONG_NAME);
        self::assertTrue($settings->updateSetting('activity_sumfields_activity_type_ids', [1]));
        self::assertTrue($settings->updateSetting('activity_sumfields_record_type_id', [2]));

        $contactId = $this->createContact();
        $activityDaysBeforeNow = [5, 35, 65, 95, 185, 370, 735];
        foreach ($activityDaysBeforeNow as $before) {
            $activityDate = date('Y-m-d H:i', strtotime($before.' days ago'));
            $activityId = $this->addActivity($contactId, 1);
            // update activity with sql
            $sql = "UPDATE civicrm_activity SET created_date = %1, activity_date_time = %1 WHERE id =  %2";
            $params = [
                1 => [$activityDate, 'String'],
                2 => [$activityId, 'Int'],
            ];
            CRM_Core_DAO::executeQuery($sql, $params);
        }
        // Enable fields
        $fields = [
            'number_of_activities_30',
            'number_of_activities_60',
            'number_of_activities_90',
            'number_of_activities_180',
            'number_of_activities_365',
            'number_of_activities_730',
        ];
        $this->enableSummaryField($fields);

        $days = ['30' => 1, '60' => 2, '90' => 3, '180' => 4, '365' => 5, '730' => 6];
        foreach ($days as $day => $expectedNumber) {
            $value = $this->getCustomFieldValue($contactId, 'The number of activities in the last '.$day.' days');
            self::assertEquals($expectedNumber, $value, 'Wrong value returned for '.$day.' day.');
        }
        $this->addActivity($contactId, 1);
        foreach ($days as $day => $expectedNumber) {
            $value = $this->getCustomFieldValue($contactId, 'The number of activities in the last '.$day.' days');
            self::assertEquals($expectedNumber+1, $value, 'Wrong value returned for '.$day.' day.');
        }
    }
    public function testDateOfActivities()
    {
        $settings = new CRM_ActivitySumfields_Config(E::LONG_NAME);
        self::assertTrue($settings->updateSetting('activity_sumfields_date_activity_type_ids', [1]));
        self::assertTrue($settings->updateSetting('activity_sumfields_date_record_type_id', [2]));

        $contactId = $this->createContact();
        $activityDate = date('Y-m-d H:i', strtotime('5 days ago'));
        $activityId = $this->addActivity($contactId, 1);
        // update activity with sql
        $sql = "UPDATE civicrm_activity SET created_date = %1, activity_date_time = %1 WHERE id =  %2";
        $params = [
            1 => [$activityDate, 'String'],
            2 => [$activityId, 'Int'],
        ];
        CRM_Core_DAO::executeQuery($sql, $params);
        // Enable fields
        $fields = [
            'date_of_the_last_activity',
        ];
        $this->enableSummaryField($fields);
        $value = $this->getCustomFieldValue($contactId, 'The date of the last activity');
        self::assertEquals($activityDate.':00', $value, 'Invalid last activity date');
    }
}
