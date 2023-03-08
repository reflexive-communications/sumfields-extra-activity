<?php

/**
 * Collection of upgrade steps.
 */
class CRM_SumfieldsAddonActivity_Upgrader extends CRM_SumfieldsAddonActivity_Upgrader_Base
{
    /**
     * Install process. Init database.
     *
     * @throws CRM_Core_Exception
     */
    public function install()
    {
        $config = new CRM_SumfieldsAddonActivity_Config($this->extensionName);
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
        $config = new CRM_SumfieldsAddonActivity_Config($this->extensionName);
        // delete current configs
        if (!$config->remove()) {
            throw new CRM_Core_Exception($this->extensionName.ts(' could not remove configs from database'));
        }
    }

    /**
     * Database upgrade for the activity date fieldsets.
     *
     * @return bool
     * @throws CRM_Core_Exception
     */
    public function upgrade_5100()
    {
        $config = new CRM_SumfieldsAddonActivity_Config($this->extensionName);
        $default = $config->defaultConfiguration();
        $config->load();
        $current = $config->get();
        $needsToBeAdded = [
            'activity_sumfields_date_activity_type_ids',
            'activity_sumfields_date_activity_status_ids',
            'activity_sumfields_date_record_type_id',
        ];
        foreach ($needsToBeAdded as $newConfig) {
            $current[$newConfig] = $default[$newConfig];
        }

        return $config->update($current);
    }
}
