<?php

/**
 * Testcases for the configuration.
 *
 * @group headless
 */
class CRM_ExtendSummaryFields_ConfigTest extends CRM_ExtendSummaryFields_HeadlessBase
{
    /**
     * It checks that the defaultConfiguration function works well.
     */
    public function testDefaultConfiguration()
    {
        $expectedKeys = ['extend_summary_fields_activity_type_ids', 'extend_summary_fields_activity_status_ids', 'extend_summary_fields_record_type_id'];
        $config = new CRM_ExtendSummaryFields_Config('config_test');
        $defaults = $config->defaultConfiguration();
        foreach ($expectedKeys as $k) {
            self::assertTrue(array_key_exists($k, $defaults));
            self::assertSame([], $defaults[$k]);
        }
        self::assertSame(count($expectedKeys), count($defaults));
    }
    /**
     * It checks that the updateSetting function works well.
     */
    public function testUpdateSetting()
    {
        $testData = [
            'extend_summary_fields_activity_type_ids' => [1,2],
            'extend_summary_fields_activity_status_ids' => [2,3,5],
            'extend_summary_fields_record_type_id' => [1],
        ];
        $config = new CRM_ExtendSummaryFields_Config('config_test');
        self::assertTrue($config->create());
        foreach ($testData as $key => $value) {
            self::assertTrue($config->updateSetting($key, $value));
            $cfg = $config->get();
            self::assertSame($value, $cfg[$key]);
        }
    }
    /**
     * It checks that the getSetting function works well.
     */
    public function testGetSetting()
    {
        $testData = [
            'extend_summary_fields_activity_type_ids' => [1,2],
            'extend_summary_fields_activity_status_ids' => [2,3,5],
            'extend_summary_fields_record_type_id' => [1],
        ];
        $config = new CRM_ExtendSummaryFields_Config('config_test');
        $config->update($testData);
        foreach ($testData as $key => $value) {
            self::assertSame($value, $config->getSetting($key));
        }
        self::assertSame([], $config->getSetting('not-existing-key'));
    }
}
