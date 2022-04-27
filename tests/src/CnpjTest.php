<?php
namespace rsporteman\ValidatorTest;

use rsporteman\Validator\Cnpj;
use PHPUnit\Framework\TestCase;

class CnpjTest extends TestCase
{

    /**
     * @dataProvider validProvider
     */
    public function testValidData($validProvider)
    {
        $cnpj = new Cnpj();
        $bol = $cnpj->isValid($validProvider);

        $messages = '';
        if ($cnpj->getMessages() != []) {
            $messages = "getMessages() return: \n";
            $i = 0;
            foreach ($cnpj->getMessages() as $message) {
                $i++;
                $messages .= $i . ": " . $message . "\n";
            }
        }

        $this->assertEquals(true, $bol, $messages);

    }

    public function validProvider()
    {
        return [
            ['48-570-041-0001-40'],
            ['48 570 041 0001 40'],
            [' 48570041000140 '],
            ['48.570.041/0001-40'],
            ['11222333000181'],
            ['48570041000140'],
            ['56016744000159'],
            ['71115136000195'],
            ['91.510.682/0001-38'],
        ];
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testInvalidData($invalidProvider)
    {
        $cnpj = new Cnpj();
        $bol = $cnpj->isValid($invalidProvider);
        $this->assertEquals(false, $bol, 'error with data: ' . $invalidProvider);
    }

    public function invalidProvider()
    {
        return array(
            array('112223330001810'),
            array(11222333000181),
            array('11222333000101'),
            array('11222333000191'),
            array('11222333000151'),
            array('11222333000182'),
            array('11222333000183'),
            array('11222333000180'),
            array('11222333000185'),
            array('00000000000000'),
            array('11111111111111'),
            array('22222222222222'),
            array('33333333333333'),
            array('44444444444444'),
            array('55555555555555'),
            array('66666666666666'),
            array('77777777777777'),
            array('88888888888888'),
            array('99999999999999'),
        );
    }
}

?>
