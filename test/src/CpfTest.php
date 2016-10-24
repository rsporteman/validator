<?php
namespace rsporteman\ValidatorTest;

use rsporteman\Validator\Cpf;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{

    /**
     * @dataProvider validProvider
     */
    public function testValidData($validProvider)
    {
        $cpf = new Cpf();
        $bol = $cpf->isValid($validProvider);

        $messages = '';
        if ($cpf->getMessages() != []) {
            $messages = "getMessages() return: \n";
            $i = 0;
            foreach ($cpf->getMessages() as $message) {
                $i++;
                $messages .= $i . ": " . $message . "\n";
            }
        }

        $this->assertEquals(true, $bol, $messages);

    }

    public function validProvider()
    {
        return array(
            array("313.734.531-68"),
            array("217.327.674-32"),
            array(" 313.734.531-68 "),
            array("313.734.531/68"),
            array("313734531-68"),
            array("313 734 531-68"),
            array("313.734.531 68"),
            array("313 734 531 68"),
            array("313-734-531-68"),
            array("31373453168"),
            array("22233366638"),
            array("72946501523"),
            array("77744345428"),
            array("18705781809"),
        );
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testInvalidData($invalidProvider)
    {
        $cpf = new Cpf();
        $bol = $cpf->isValid($invalidProvider);
        $this->assertEquals(false, $bol, 'error with data: ' . $invalidProvider);
    }

    public function invalidProvider()
    {
        return array(
            array('313.734.531-6800'),
            array('3137345316815800'),
            array(31373453168159),
            array("313.734.531-63"),
            array("31373453169"),
            array("000.000.000-00"),
            array("00000000000"),
            array("11111111111"),
            array("22222222222"),
            array("33333333333"),
            array("44444444444"),
            array("55555555555"),
            array("66666666666"),
            array("77777777777"),
            array("88888888888"),
            array("99999999999"),
        );
    }
}

?>
