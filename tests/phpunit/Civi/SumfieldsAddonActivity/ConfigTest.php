<?php

namespace Civi\SumfieldsAddonActivity;

/**
 * @group headless
 */
class ConfigTest extends HeadlessTestCase
{
    /**
     * @return void
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
        $config = new Config('config_test');
        $defaults = $config->defaultConfiguration();
        foreach ($expectedKeys as $k) {
            self::assertTrue(array_key_exists($k, $defaults));
            self::assertSame([], $defaults[$k]);
        }
        self::assertSame(count($expectedKeys), count($defaults));
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
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
        $config = new Config('config_test');
        self::assertTrue($config->create());
        foreach ($testData as $key => $value) {
            self::assertTrue($config->updateSetting($key, $value));
            $cfg = $config->get();
            self::assertSame($value, $cfg[$key]);
        }
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
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
        $config = new Config('config_test');
        $config->update($testData);
        foreach ($testData as $key => $value) {
            self::assertSame($value, $config->getSetting($key));
        }
        self::assertSame([], $config->getSetting('not-existing-key'));
    }
}
