<?php

/**
 * Installer application tests.
 *
 * @group headless
 */
class CRM_SumfieldsAddonActivity_UpgraderTest extends CRM_SumfieldsAddonActivity_HeadlessBase
{
    /**
     * Test the install process.
     */
    public function testInstall()
    {
        $installer = new CRM_SumfieldsAddonActivity_Upgrader("ext_test", ".");
        self::assertEmpty($installer->install());
    }

    /**
     * Test the uninstall process.
     */
    public function testUninstall()
    {
        $installer = new CRM_SumfieldsAddonActivity_Upgrader("ext_test", ".");
        self::assertEmpty($installer->install());
        self::assertEmpty($installer->uninstall());
    }

    /*
     * Check the settings key update.
     */
    public function testUpdate5100()
    {
        $installer = new CRM_SumfieldsAddonActivity_Upgrader("ext_test", ".");
        self::assertEmpty($installer->install());
        $config = new CRM_SumfieldsAddonActivity_Config("ext_test");
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
