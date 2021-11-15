<?php

use CRM_ActivitySumfields_ExtensionUtil as E;

/**
 * Testcases for Service class.
 *
 * @group headless
 */
class CRM_ActivitySumfields_ServiceTest extends CRM_ActivitySumfields_HeadlessBase
{
    /*
     * It tests the sumfieldsDefinition function.
     */
    public function testSumfieldsDefinition()
    {
        $definitions = [];
        self::assertEmpty(CRM_ActivitySumfields_Service::sumfieldsDefinition($definitions));
        // the definition list has to be extended.
        self::assertTrue(array_key_exists('fields', $definitions));
        self::assertTrue(array_key_exists('optgroups', $definitions));
        self::assertCount(6, $definitions['fields']);
        self::assertCount(1, $definitions['optgroups']);
        self::assertTrue(array_key_exists('activity_sumfields', $definitions['optgroups']));
    }
    /*
     * It tests the buildForm function.
     */
    public function testBuildFormDoesNothingWhenTheFormIsIrrelevant()
    {
        $form = new CRM_Sumfields_Form_SumFields();
        self::assertEmpty(CRM_ActivitySumfields_Service::buildForm('irrelevant-form-name', $form));
    }
    public function testBuildForm()
    {
        $form = new CRM_Sumfields_Form_SumFields();
        $form->assign('fieldsets', []);
        self::assertEmpty(CRM_ActivitySumfields_Service::buildForm(CRM_Sumfields_Form_SumFields::class, $form));
        self::assertEmpty(CRM_ActivitySumfields_Service::buildForm('Not_Relevant_Class_Name', $form));
    }
    /**
     * Test the postProcess function.
     */
    public function testPostProcessDoesNothingWhenTheFormIsIrrelevant()
    {
        $form = new CRM_Sumfields_Form_SumFields();
        self::assertEmpty(CRM_ActivitySumfields_Service::postProcess('irrelevant-form-name', $form));
    }
    public function testPostProcessNotOnSubmit()
    {
        $form = new CRM_Sumfields_Form_SumFields();
        $submit = [
            'when_to_apply_change' => 'later',
            'activity_sumfields_activity_type_ids' => [],
            'activity_sumfields_activity_status_ids' => [],
            'activity_sumfields_record_type_id' => '',
        ];
        $form->setVar('_submitValues', $submit);
        self::assertEmpty(CRM_ActivitySumfields_Service::postProcess(CRM_Sumfields_Form_SumFields::class, $form));
    }
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
        ];
        $form->setVar('_submitValues', $submit);
        self::assertEmpty(CRM_ActivitySumfields_Service::postProcess(CRM_Sumfields_Form_SumFields::class, $form));
        $config = new CRM_ActivitySumfields_Config(E::LONG_NAME);
        self::assertSame($expectedActivityTypeIds, $config->getSetting('activity_sumfields_activity_type_ids'));
        self::assertSame($expectedActivityStatusIds, $config->getSetting('activity_sumfields_activity_status_ids'));
        self::assertSame($expectedContactRecortId, $config->getSetting('activity_sumfields_record_type_id'));
    }
}
