<?php
namespace rsporteman\Validator;

use Zend\Validator\AbstractValidator;

class Cpf extends AbstractValidator
{
    const INVALID        = 'cpfInvalid';
    const LENGTH         = 'cpfLength';
    const CHECKSUM       = 'cpfChecksum';
    const FICTITIOUS     = 'cpfFictitious';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID        => "Invalid type given. String expected",
        self::LENGTH         => "The input contains an invalid amount of characters",
        self::CHECKSUM       => "The input seems to contain an invalid checksum",
        self::FICTITIOUS     => "The input contains a mathematically valid cpf but it seems fictitious cpf number",
    ];

    public function isValid($cpf)
    {
        $this->checkType($cpf);
        $cpf = str_replace(" ", "", $cpf);
        $cpf = str_replace("/", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        $cpf = str_replace(".", "", $cpf);
        $this->checkSize($cpf);

        if($this->getMessages() != []){
            return false;
        }

        $this->checkDigitOne($cpf);
        $this->checkDigitTwo($cpf);
        $this->isFictitious($cpf);


        if($this->getMessages()==[]) {
            return true;
        }

        return false;
    }

    protected function checkType($cpf)
    {
        if (!is_string($cpf)) {
            $this->error(self::INVALID, $cpf);
        }
    }

    protected function checkSize($cpf)
    {
        if (\strlen($cpf) != 11) {
            $this->error(self::LENGTH, $cpf);
        }
    }

    protected function checkDigitOne($cpf)
    {
        $cpfArr = \str_split($cpf);
        $calculateDigitOne = $this->calculateDigitOne($cpf);

        if ($calculateDigitOne != $cpfArr[9]) {
            $this->error(self::CHECKSUM, $cpf);
        }
    }

    protected function checkDigitTwo($cpf)
    {
        $cpfArr = \str_split($cpf);
        $calculateDigitTwo = $this->calculateDigitTwo($cpf);

        if ($calculateDigitTwo != $cpfArr[10]) {
            $this->error(self::CHECKSUM, $cpf);
        }
    }

    /*
     * CPFs as 000 are mathematically valid but are false and should be filtered.
     */
    protected function isFictitious($cpf)
    {
        for ($i = 0; $i < 10; $i++) {
            if ($cpf[0] == $i && $cpf[1] == $i && $cpf[2] == $i && $cpf[3] == $i && $cpf[4] == $i && $cpf[5] == $i && $cpf[6] == $i && $cpf[7] == $i && $cpf[8] == $i) {
                $this->error(self::FICTITIOUS, $cpf);
            }
        }
    }

    protected function calculateDigitOne($cpf)
    {

        $stepMultiplication[0] = $cpf[0] * 10;
        $stepMultiplication[1] = $cpf[1] * 9;
        $stepMultiplication[2] = $cpf[2] * 8;
        $stepMultiplication[3] = $cpf[3] * 7;
        $stepMultiplication[4] = $cpf[4] * 6;
        $stepMultiplication[5] = $cpf[5] * 5;
        $stepMultiplication[6] = $cpf[6] * 4;
        $stepMultiplication[7] = $cpf[7] * 3;
        $stepMultiplication[8] = $cpf[8] * 2;

        $stepSum = \array_sum($stepMultiplication);

        $stepRemainder = $stepSum % 11;

        if ($stepRemainder < 2) {
            $checkDigit = 0;
        } else {
            $checkDigit = 11 - $stepRemainder;
        }

        return $checkDigit;
    }

    protected function calculateDigitTwo($cpf)
    {

        $stepMultiplication[0] = $cpf[0] * 11;
        $stepMultiplication[1] = $cpf[1] * 10;
        $stepMultiplication[2] = $cpf[2] * 9;
        $stepMultiplication[3] = $cpf[3] * 8;
        $stepMultiplication[4] = $cpf[4] * 7;
        $stepMultiplication[5] = $cpf[5] * 6;
        $stepMultiplication[6] = $cpf[6] * 5;
        $stepMultiplication[7] = $cpf[7] * 4;
        $stepMultiplication[8] = $cpf[8] * 3;
        $stepMultiplication[9] = $cpf[9] * 2;

        $stepSum = \array_sum($stepMultiplication);

        $stepRemainder = $stepSum % 11;

        if ($stepRemainder < 2) {
            $checkDigit = 0;
        } else {
            $checkDigit = 11 - $stepRemainder;
        }

        return $checkDigit;
    }
}

?>