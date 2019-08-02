<?php


namespace app\modules\api\models;


class RandomGenerator {

    // MARK: - Public

    public function generateInt() : int {
        return mt_rand(0, PHP_INT_MAX);
    }

    public function generateString() : string {
        return $this->generateFromSymbols('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
    }

    public function generateMixed() : string {
        return $this->generateFromSymbols('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890123456789');
    }

    // MARK: - Private

    private function generateFromSymbols(string $symbols) : string {
        $symbolsCount = strlen($symbols);
        $length = 32;

        $result = '';
        for ($i = 0; $i <= $length; $i++) {
            $randomIndex = mt_rand(0, $symbolsCount - 1);
            $result .= $symbols[$randomIndex];
        }

        return $result;
    }

}