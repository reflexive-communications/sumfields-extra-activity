<?php

use CRM_ExtendSummaryFields_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;

/**
 * Testcases for Service class.
 *
 * @group headless
 */
class CRM_ExtendSummaryFields_ServiceTest extends \PHPUnit\Framework\TestCase implements HeadlessInterface, HookInterface, TransactionalInterface
{
    public function setUpHeadless()
    {
        return \Civi\Test::headless()
            ->install('net.ourpowerbase.sumfields')
            ->install('rc-base')
            ->installMe(__DIR__)
            ->apply();
    }

    /**
     * Apply a forced rebuild of DB, thus
     * create a clean DB before running tests
     *
     * @throws \CRM_Extension_Exception_ParseException
     */
    public static function setUpBeforeClass(): void
    {
        // Resets DB and install depended extension
        \Civi\Test::headless()
            ->install('net.ourpowerbase.sumfields')
            ->install('rc-base')
            ->installMe(__DIR__)
            ->apply(true);
    }

    /**
     * Create a clean DB after running tests
     *
     * @throws CRM_Extension_Exception_ParseException
     */
    public static function tearDownAfterClass(): void
    {
        \Civi\Test::headless()
            ->uninstallMe(__DIR__)
            ->uninstall('rc-base')
            ->uninstall('net.ourpowerbase.sumfields')
            ->apply(true);
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /*
     * It tests the sumfieldsDefinition function.
     */
    public function testSumfieldsDefinition()
    {
        $definitions = [];
        self::assertEmpty(CRM_ExtendSummaryFields_Service::sumfieldsDefinition($definitions));
        // the definition list has to be extended.
        self::assertTrue(array_key_exists('fields', $definitions));
        self::assertTrue(array_key_exists('optgroups', $definitions));
        self::assertCount(6, $definitions['fields']);
        self::assertCount(1, $definitions['optgroups']);
        self::assertTrue(array_key_exists('extend_summary_fields', $definitions['optgroups']));
    }
    /*
     * It tests the buildForm function.
     */
    public function testBuildFormDoesNothingWhenTheFormIsIrrelevant()
    {
        self::assertEmpty(CRM_ExtendSummaryFields_Service::buildForm('irrelevant-form-name', new CRM_Sumfields_Form_SumFields()));
    }
    public function testBuildForm()
    {
        $form = new CRM_Sumfields_Form_SumFields();
        $form->setVar('fieldsets', []);
        self::assertEmpty(CRM_ExtendSummaryFields_Service::buildForm(CRM_Sumfields_Form_SumFields::class, $form));
        self::assertEmpty(CRM_ExtendSummaryFields_Service::buildForm('Not_Relevant_Class_Name', $form));
    }
    /**
     * Test the postProcess function.
     */
    public function testPostProcessDoesNothingWhenTheFormIsIrrelevant()
    {
        self::assertEmpty(CRM_ExtendSummaryFields_Service::postProcess('irrelevant-form-name', new CRM_Sumfields_Form_SumFields()));
    }
    public function testPostProcessNotOnSubmit()
    {
        $form = new CRM_Sumfields_Form_SumFields();
        $form->setVar('when_to_apply_change', 'later');
        $form->setVar('extend_summary_fields_activity_type_ids', []);
        $form->setVar('extend_summary_fields_activity_status_ids', []);
        $form->setVar('extend_summary_fields_record_type_id', []);
        self::assertEmpty(CRM_ExtendSummaryFields_Service::postProcess(CRM_Sumfields_Form_SumFields::class, $form));
    }
    public function testPostProcessOnSubmit()
    {
        $form = new CRM_Sumfields_Form_SumFields();
        $expectedActivityTypeIds = array_keys(CRM_Activity_BAO_Activity::buildOptions('activity_type_id', 'get'));
        $expectedActivityStatusIds = array_keys(CRM_Activity_BAO_Activity::buildOptions('activity_status_id', 'get'));
        $expectedContactRecortId = [array_keys(CRM_Activity_BAO_ActivityContact::buildOptions('record_type_id', 'get'))[0]];
        $form->setVar('when_to_apply_change', 'on_submit');
        $form->setVar('extend_summary_fields_activity_type_ids', $expectedActivityTypeIds);
        $form->setVar('extend_summary_fields_activity_status_ids', $expectedActivityStatusIds);
        $form->setVar('extend_summary_fields_record_type_id', $expectedContactRecortId);
        self::assertEmpty(CRM_ExtendSummaryFields_Service::postProcess(CRM_Sumfields_Form_SumFields::class, $form));
        self::assertSame($expectedActivityTypeIds, sumfields_get_setting('extend_summary_fields_activity_type_ids'));
        self::assertSame($expectedActivityStatusIds, sumfields_get_setting('extend_summary_fields_activity_status_ids'));
        self::assertSame($expectedContactRecortId, sumfields_get_setting('extend_summary_fields_record_type_id'));
    }
}
