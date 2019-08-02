<?php


namespace app\modules\api\factory;


use app\modules\api\models\RandomObject;
use Faker\Provider\Uuid;

class GeneratorFactory {

    static function requestRandomObject(string $value, string $type) : RandomObject {
         return new RandomObject(Uuid::uuid(), $value, $type);
    }

}