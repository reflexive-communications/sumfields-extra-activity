<?php

class CRM_ExtendSummaryFields_Config extends CRM_RcBase_Config
{
    /**
     * Provides a default configuration object.
     *
     * @return array the default configuration object.
     */
    public function defaultConfiguration(): array
    {
        return [
            'extend_summary_fields_activity_type_ids' => [],
            'extend_summary_fields_activity_status_ids' => [],
            'extend_summary_fields_record_type_id' => [],
        ];
    }

    /**
     * Updates a setting key.
     *
     * @param string $key
     * @param array $settings the data to save
     *
     * @return bool the status of the update process.
     *
     * @throws CRM_Core_Exception.
     */
    public function updateSetting(string $key, array $settings): bool
    {
        // load latest config
        parent::load();
        $configuration = parent::get();
        $configuration[$key] = $settings;
        return parent::update($configuration);
    }

    /**
     * Updates a setting key.
     *
     * @param string $key
     *
     * @return array the settings for the key
     *
     * @throws CRM_Core_Exception.
     */
    public function getSetting(string $key): array
    {
        // load latest config
        parent::load();
        $configuration = parent::get();
        return isset($configuration[$key]) ? $configuration[$key] : [];
    }
}