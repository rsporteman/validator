<?php

namespace rsporteman\Validator;

use Laminas\Validator\AbstractValidator;

class Cnpj extends AbstractValidator
{
    const INVALID        = 'cnpjInvalid';
    const LENGTH         = 'cnpjLength';
    const CHECKSUM       = 'cnpjChecksum';
    const FICTITIOUS     = 'cnpjFictitious';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID        => "Invalid type given. String expected",
        self::LENGTH         => "The input contains an invalid amount of characters",
        self::CHECKSUM       => "The input seems to contain an invalid checksum",
        self::FICTITIOUS     => "The input contains a mathematically valid cnpj but it seems fictitious cnpj number",
    ];

    public function isValid($cnpj)
    {
        $this->checkType($cnpj);
        $cnpj = str_replace(" ", "", $cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace(".", "", $cnpj);
        $this->checkSize($cnpj);

        if($this->getMessages() != []){
            return false;
        }

        $this->checkDigitOne($cnpj);
        $this->checkDigitTwo($cnpj);
        $this->isFictitious($cnpj);

        if($this->getMessages()==[]) {
            return true;
        }

        return false;
    }

    protected function checkType($cnpj)
    {
        if (!is_string($cnpj)) {
            $this->error(self::INVALID, $cnpj);
        }
    }

    protected function checkSize($cnpj)
    {
        if (\strlen($cnpj) != 14) {
            $this->error(self::LENGTH, $cnpj);
        }
    }

    protected function checkDigitOne($cnpj)
    {
        $cnpjArr = \str_split($cnpj);
        $calculateDigitOne = $this->calculateDigitOne($cnpj);

        if ($calculateDigitOne != $cnpjArr[12]) {
            $this->error(self::CHECKSUM, $cnpj);
        }

    }

    protected function checkDigitTwo($cnpj)
    {
        $cnpjArr = \str_split($cnpj);
        $calculateDigitTwo = $this->calculateDigitTwo($cnpj);

        if ($calculateDigitTwo != $cnpjArr[13]) {
            $this->error(self::CHECKSUM, $cnpj);
        }
    }

    protected function isFictitious($cnpj)
    {
        if ($cnpj === "00000000000000") {
            $this->error(self::FICTITIOUS, $cnpj);
        }
    }

    protected function calculateDigitOne($cnpj)
    {

        $stepMultiplication[0] = $cnpj[0] * 5;
        $stepMultiplication[1] = $cnpj[1] * 4;
        $stepMultiplication[2] = $cnpj[2] * 3;
        $stepMultiplication[3] = $cnpj[3] * 2;
        $stepMultiplication[4] = $cnpj[4] * 9;
        $stepMultiplication[5] = $cnpj[5] * 8;
        $stepMultiplication[6] = $cnpj[6] * 7;
        $stepMultiplication[7] = $cnpj[7] * 6;
        $stepMultiplication[8] = $cnpj[8] * 5;
        $stepMultiplication[9] = $cnpj[9] * 4;
        $stepMultiplication[10] = $cnpj[10] * 3;
        $stepMultiplication[11] = $cnpj[11] * 2;

        $stepSum = \array_sum($stepMultiplication);

        $stepRemainder = $stepSum % 11;

        if ($stepRemainder < 2) {
            $checkDigit = 0;
        } else {
            $checkDigit = 11 - $stepRemainder;
        }

        return $checkDigit;
    }

    protected function calculateDigitTwo($cnpj)
    {

        $stepMultiplication[0] = $cnpj[0] * 6;
        $stepMultiplication[1] = $cnpj[1] * 5;
        $stepMultiplication[2] = $cnpj[2] * 4;
        $stepMultiplication[3] = $cnpj[3] * 3;
        $stepMultiplication[4] = $cnpj[4] * 2;
        $stepMultiplication[5] = $cnpj[5] * 9;
        $stepMultiplication[6] = $cnpj[6] * 8;
        $stepMultiplication[7] = $cnpj[7] * 7;
        $stepMultiplication[8] = $cnpj[8] * 6;
        $stepMultiplication[9] = $cnpj[9] * 5;
        $stepMultiplication[10] = $cnpj[10] * 4;
        $stepMultiplication[11] = $cnpj[11] * 3;
        $stepMultiplication[12] = $cnpj[12] * 2;

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