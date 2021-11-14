<?php

/**
 * Installer application tests.
 *
 * @group headless
 */
class CRM_ExtendSummaryFields_UpgraderTest extends CRM_ExtendSummaryFields_HeadlessBase
{
    /**
     * Test the install process.
     */
    public function testInstall()
    {
        $installer = new CRM_ExtendSummaryFields_Upgrader("ext_test", ".");
        self::assertEmpty($installer->install());
    }

    /**
     * Test the uninstall process.
     */
    public function testUninstall()
    {
        $installer = new CRM_ExtendSummaryFields_Upgrader("ext_test", ".");
        self::assertEmpty($installer->install());
        self::assertEmpty($installer->uninstall());
    }
}
