<?php

namespace Sourceboat\Enumeration\Tests;

use Eloquent\Enumeration\Exception\UndefinedMemberException;

class ModelHasEnumsTraitTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->model = new TestModel;
    }

    /**
     * Check if the default member gets returned from attribute
     * access when the attribute is null (or a value not represented by the enum).
     */
    public function testGetDefaultMemberWhenNotSet(): void
    {
        $this->assertNotNull($this->model->test);
        $this->assertEquals(TestEnum::defaultMember(), $this->model->test);
    }

    /**
     * Check if null gets returned from attribute
     * access when the attribute is null and set as nullable.
     */
    public function testGetNullWhenNotSetAndNullable(): void
    {
        $this->assertNull($this->model->test2);
    }

    /**
     * Check if the validation when setting an enum-property
     * with a wrong value throws an exception.
     */
    public function testSetterValidationWithWrongValue(): void
    {
        try {
            $this->model->test = 'test';
            $this->assertTrue(false, 'undefined value was set.');
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * Check if the validation when setting an enum-property
     * with a correct scalar value throws no exception.
     */
    public function testSetterValidationWithCorrectSkalarValue(): void
    {
        try {
            $this->model->test = 'test_2';
            $this->assertTrue(true);
            $this->assertEquals(TestEnum::TEST2(), $this->model->test);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value was rejected');
        }
    }

    /**
     * Check if the validation when setting an enum-property
     * with a correct value of null throws no exception.
     */
    public function testSetterValidationWithCorrectNullValue(): void
    {
        try {
            $this->model->test2 = TestEnum2::TEST2();
            $this->assertEquals(TestEnum2::TEST2(), $this->model->test2);

            $this->model->test2 = null;
            $this->assertTrue(true);
            $this->assertNull($this->model->test2);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value was rejected');
        }
    }

    /**
     * Check if the validation when setting an enum-property
     * with a correct skalar value throws no exception.
     */
    public function testSetterValidationWithCorrectMember(): void
    {
        try {
            $this->model->test = TestEnum::TEST3();
            $this->assertTrue(true);
            $this->assertEquals(TestEnum::TEST3(), $this->model->test);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value was rejected');
        }
    }
}
