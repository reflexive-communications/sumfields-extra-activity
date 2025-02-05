<?php

namespace Civi\SumfieldsExtraActivity;

use CRM_Activity_BAO_Activity;
use CRM_Activity_BAO_ActivityContact;
use CRM_Sumfields_Form_SumFields;
use CRM_SumfieldsExtraActivity_ExtensionUtil as E;

/**
 * @group headless
 */
class ServiceTest extends HeadlessTestCase
{
    /**
     * @return void
     */
    public function testSumfieldsDefinition()
    {
        $definitions = [];
        Service::sumfieldsDefinition($definitions);
        // the definition list has to be extended.
        self::assertCount(7, $definitions['fields']);
        self::assertCount(2, $definitions['optgroups']);
        self::assertArrayHasKey('activity_sumfields', $definitions['optgroups']);
        self::assertArrayHasKey('activity_sumfields_date_of_activity', $definitions['optgroups']);
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testPostProcessOnSubmit()
    {
        $form = new CRM_Sumfields_Form_SumFields();
        $expectedActivityTypeIds = array_keys(CRM_Activity_BAO_Activity::buildOptions('activity_type_id', 'get'));
        $expectedActivityStatusIds = array_keys(CRM_Activity_BAO_Activity::buildOptions('activity_status_id', 'get'));
        $expectedContactRecortId = array_keys(CRM_Activity_BAO_ActivityContact::buildOptions('record_type_id', 'get'))[0];
        $submit = [
            'when_to_apply_change' => 'on_submit',
            'activity_sumfields_activity_type_ids' => $expectedActivityTypeIds,
            'activity_sumfields_activity_status_ids' => $expectedActivityStatusIds,
            'activity_sumfields_record_type_id' => $expectedContactRecortId,
            'activity_sumfields_date_activity_type_ids' => $expectedActivityTypeIds,
            'activity_sumfields_date_activity_status_ids' => $expectedActivityStatusIds,
            'activity_sumfields_date_record_type_id' => $expectedContactRecortId,
        ];
        $form->_submitValues = $submit;
        Service::postProcess(CRM_Sumfields_Form_SumFields::class, $form);
        $config = new Config(E::LONG_NAME);
        self::assertSame($expectedActivityTypeIds, $config->getSetting('activity_sumfields_activity_type_ids'));
        self::assertSame($expectedActivityTypeIds, $config->getSetting('activity_sumfields_date_activity_type_ids'));
        self::assertSame($expectedActivityStatusIds, $config->getSetting('activity_sumfields_activity_status_ids'));
        self::assertSame($expectedActivityStatusIds, $config->getSetting('activity_sumfields_date_activity_status_ids'));
        self::assertSame([$expectedContactRecortId], $config->getSetting('activity_sumfields_record_type_id'));
        self::assertSame([$expectedContactRecortId], $config->getSetting('activity_sumfields_date_record_type_id'));
    }
}
