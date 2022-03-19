<?php

/**
 * Testcases for the configuration.
 *
 * @group headless
 */
class CRM_SumfieldsAddonActivity_ConfigTest extends CRM_SumfieldsAddonActivity_HeadlessBase
{
    /**
     * It checks that the defaultConfiguration function works well.
     */
    public function testDefaultConfiguration()
    {
        $expectedKeys = [
            'activity_sumfields_activity_type_ids',
            'activity_sumfields_activity_status_ids',
            'activity_sumfields_record_type_id',
            'activity_sumfields_date_activity_type_ids',
            'activity_sumfields_date_activity_status_ids',
            'activity_sumfields_date_record_type_id',
        ];
        $config = new CRM_SumfieldsAddonActivity_Config('config_test');
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
            'activity_sumfields_activity_type_ids' => [1, 2],
            'activity_sumfields_activity_status_ids' => [2, 3, 5],
            'activity_sumfields_record_type_id' => [1],
            'activity_sumfields_date_activity_type_ids' => [1, 2],
            'activity_sumfields_date_activity_status_ids' => [2, 3, 5],
            'activity_sumfields_date_record_type_id' => [1],
        ];
        $config = new CRM_SumfieldsAddonActivity_Config('config_test');
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
            'activity_sumfields_activity_type_ids' => [1, 2],
            'activity_sumfields_activity_status_ids' => [2, 3, 5],
            'activity_sumfields_record_type_id' => [1],
            'activity_sumfields_date_activity_type_ids' => [1, 2],
            'activity_sumfields_date_activity_status_ids' => [2, 3, 5],
            'activity_sumfields_date_record_type_id' => [1],
        ];
        $config = new CRM_SumfieldsAddonActivity_Config('config_test');
        $config->update($testData);
        foreach ($testData as $key => $value) {
            self::assertSame($value, $config->getSetting($key));
        }
        self::assertSame([], $config->getSetting('not-existing-key'));
    }
}
