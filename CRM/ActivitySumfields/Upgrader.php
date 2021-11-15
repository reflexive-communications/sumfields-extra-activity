<?php
use CRM_ActivitySumfields_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_ActivitySumfields_Upgrader extends CRM_ActivitySumfields_Upgrader_Base
{
    /**
     * Install process. Init database.
     *
     * @throws CRM_Core_Exception
     */
    public function install()
    {
        $config = new CRM_ActivitySumfields_Config($this->extensionName);
        // Create default configs
        if (!$config->create()) {
            throw new CRM_Core_Exception($this->extensionName.ts(' could not create configs in database'));
        }
    }

    /**
     * Uninstall process. Clean database.
     *
     * @throws CRM_Core_Exception
     */
    public function uninstall()
    {
        $config = new CRM_ActivitySumfields_Config($this->extensionName);
        // delete current configs
        if (!$config->remove()) {
            throw new CRM_Core_Exception($this->extensionName.ts(' could not remove configs from database'));
        }
    }
}
