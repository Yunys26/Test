<?php


namespace app\modules\api\controllers;


use app\modules\api\models\Entity;
use app\modules\api\models\RandomObject;
use yii\filters\VerbFilter;

class RetrieveController extends RestController {

    // MARK: - System

    public function behaviors() {
        return parent::behaviors() + [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'index' => ['get']
                    ]
                ]
            ];
    }

    // MARK: - Interface

    public function actionIndex(string $id = null, $requestId = null) {
        if ($id) {
            $object = $this->repo->get($id, RandomObject::class);
            return $this->resultBy($object);
        }

        if ($requestId) {
            $object = $this->repo->getCustom('requestId', $requestId, RandomObject::class);
            return $this->resultBy($object);
        }

        return $this->errorResult('parameters is null');
    }

    // MARK: - Private

    private function resultBy(?Entity $object): array {
        if ($object) {
            return $this->successResult($object);
        }
        return $this->errorResult('object not found');
    }

}