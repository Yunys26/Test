<?php

namespace app\modules\api\controllers;


use app\modules\api\factory\GeneratorFactory;
use app\modules\api\models\RandomGenerator;

use Yii;
use yii\filters\VerbFilter;

class GenerateController extends RestController {

    // MARK: - System

    public function behaviors() {
        return parent::behaviors() + [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post']
                ]
            ]
        ];
    }

    // MARK: - Actions

    public function actionIndex() {
        $type = $this->data['type'];
        $generator = new RandomGenerator();

        $value = null;
        switch ($type) {
            case 'int':     $value = $generator->generateInt();     break;
            case 'string':  $value = $generator->generateString();  break;
            case 'mixed':   $value = $generator->generateMixed();   break;
        }

        if (!$value) {
            return $this->errorResult('generate value is null');
        }

        $object = GeneratorFactory::requestRandomObject($value, $type);

        if (!$this->repo->add($object)) {
            return $this->errorResult('can\'t add to database');
        }

        return $this->successResult($object);
    }

}