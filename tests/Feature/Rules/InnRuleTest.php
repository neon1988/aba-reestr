<?php

namespace Tests\Feature\Rules;

use App\Rules\InnRule;
use Tests\TestCase;

class InnRuleTest extends TestCase
{
    /**
     * Проверяет корректность 10-значного ИНН (организации).
     */
    public function testValidInn10()
    {
        $rule = new InnRule();

        $this->assertTrue($rule->passes('inn', '333252760845'));
        $this->assertTrue($rule->passes('inn', '7743013901'));

        $array = [
            '896107328524',
            '255278763001',
            '358439677450',
            '316107390581',
            '695427388821',
            '328145783618',
            '802531286900',
            '682807639501',
            '498667320200',
            '249082492189',
            '080201572513',
            '922049296279',
            '631450753700',
        ];

        foreach ($array as $inn)
        {
            $this->assertTrue($rule->passes('inn', $inn), 'ИНН '.$inn.' должен быть валидным');
        }
    }

    /**
     * Проверяет некорректные 10-значные ИНН.
     */
    public function testInvalidInn10()
    {
        $rule = new InnRule();

        $this->assertFalse($rule->passes('inn', '5001007327'), 'ИНН 5001007327 не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '7743013902'), 'ИНН 7743013902 не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '1234567890'), 'ИНН 1234567890 не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '500100732'), 'ИНН с недостаточным количеством цифр не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '50010073271'), 'ИНН с лишними цифрами не должен быть валидным');
    }

    /**
     * Проверяет корректность 12-значного ИНН (физического лица/ИП).
     */
    public function testValidInn12()
    {
        $rule = new InnRule();

        $this->assertTrue($rule->passes('inn', '500100732259'), 'ИНН 500100732259 должен быть валидным');
    }

    /**
     * Проверяет некорректные 12-значные ИНН.
     */
    public function testInvalidInn12()
    {
        $rule = new InnRule();

        $this->assertFalse($rule->passes('inn', '774301390113'), 'ИНН 774301390113 не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '500100732258'), 'ИНН 500100732258 не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '77430139011'), 'ИНН с недостаточным количеством цифр не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '7743013901123'), 'ИНН с лишними цифрами не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '774301390112'), 'ИНН 774301390112 не должен быть валидным');
    }

    /**
     * Проверяет ИНН с некорректными символами.
     */
    public function testInvalidInnCharacters()
    {
        $rule = new InnRule();

        $this->assertFalse($rule->passes('inn', '77430A3901'), 'ИНН с буквами не должен быть валидным');
        $this->assertFalse($rule->passes('inn', '774301390!'), 'ИНН с символами не должен быть валидным');
    }

    /**
     * Проверяет корректное сообщение об ошибке.
     */
    public function testErrorMessage()
    {
        $rule = new InnRule();

        $this->assertEquals(__('validation.inn'), $rule->message(), 'Сообщение об ошибке должно соответствовать ожидаемому');
    }

    /**
     * Проверяет корректность 12-значного ИНН (физического лица/ИП).
     */
    public function testGeneratorValidate()
    {
        $rule = new InnRule();

        for ($a = 0; $a < 1000; $a++)
        {
            $inn = generateINNFL();
            $this->assertTrue($rule->passes('inn', $inn), 'ИНН '.$inn.' должен быть валидным');
        }

        for ($a = 0; $a < 1000; $a++)
        {
            $inn = generateINNUL();
            $this->assertTrue($rule->passes('inn', $inn), 'ИНН '.$inn.' должен быть валидным');
        }
    }
}
