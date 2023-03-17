<?php

use Civi\SumfieldsAddonActivity\HeadlessTestCase;

/**
 * @group headless
 */
class CRM_SumfieldsAddonActivity_UpgraderTest extends HeadlessTestCase
{
    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testInstall()
    {
        $installer = new CRM_SumfieldsAddonActivity_Upgrader();
        self::assertEmpty($installer->install());
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testUninstall()
    {
        $installer = new CRM_SumfieldsAddonActivity_Upgrader();
        self::assertEmpty($installer->install());
        self::assertEmpty($installer->uninstall());
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testUpdate5100()
    {
        $installer = new CRM_SumfieldsAddonActivity_Upgrader();
        self::assertEmpty($installer->install());
        $config = new CRM_SumfieldsAddonActivity_Config(CRM_SumfieldsAddonActivity_ExtensionUtil::LONG_NAME);
        $config->load();
        $cfg = $config->get();
        $needsToBeRemoved = ['activity_sumfields_date_activity_type_ids', 'activity_sumfields_date_activity_status_ids', 'activity_sumfields_date_record_type_id'];
        foreach ($needsToBeRemoved as $newConfig) {
            unset($$newConfig);
        }
        $config->update($cfg);
        self::assertTrue($installer->upgrade_5100());
        $config->load();
        $defaultConfig = $config->defaultConfiguration();
        $currentConfig = $config->get();
        foreach ($defaultConfig as $k => $v) {
            self::assertSame($v, $currentConfig[$k]);
        }
        self::assertSame(count($defaultConfig), count($currentConfig));
    }
}
