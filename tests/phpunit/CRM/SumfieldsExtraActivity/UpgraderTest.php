<?php

use Civi\SumfieldsExtraActivity\Config;
use Civi\SumfieldsExtraActivity\HeadlessTestCase;
use CRM_SumfieldsExtraActivity_ExtensionUtil as E;

/**
 * @group headless
 */
class CRM_SumfieldsExtraActivity_UpgraderTest extends HeadlessTestCase
{
    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testInstall()
    {
        $installer = new CRM_SumfieldsExtraActivity_Upgrader();
        self::assertEmpty($installer->install());
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testUninstall()
    {
        $installer = new CRM_SumfieldsExtraActivity_Upgrader();
        self::assertEmpty($installer->install());
        self::assertEmpty($installer->uninstall());
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testUpdate2010()
    {
        $installer = new CRM_SumfieldsExtraActivity_Upgrader();
        self::assertEmpty($installer->install());
        $config = new Config(E::LONG_NAME);
        $config->load();
        $cfg = $config->get();
        $needsToBeRemoved = ['activity_sumfields_date_activity_type_ids', 'activity_sumfields_date_activity_status_ids', 'activity_sumfields_date_record_type_id'];
        foreach ($needsToBeRemoved as $newConfig) {
            unset($$newConfig);
        }
        $config->update($cfg);
        self::assertTrue($installer->upgrade_2010());
        $config->load();
        $defaultConfig = $config->defaultConfiguration();
        $currentConfig = $config->get();
        foreach ($defaultConfig as $k => $v) {
            self::assertSame($v, $currentConfig[$k]);
        }
        self::assertSame(count($defaultConfig), count($currentConfig));
    }
}
