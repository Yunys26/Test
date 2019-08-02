<?php


namespace app\modules\api\repository;


use app\modules\api\models\Entity;
use ElisDN\Hydrator\Hydrator;
use ReflectionException;
use Yii;
use yii\mongodb\Connection;
use yii\mongodb\Exception;

class Repository implements RepositoryInterface {

    // MARK: - Properties

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @var Connection
     */
    private $conn;

    // MARK: - Init

    public function __construct() {
        $this->hydrator = new Hydrator();
        $this->conn = Yii::$app->get('mongodb');
    }

    // MARK: - Interface

    function get(string $id, string $class): ?Entity {
        $data = $this->conn
            ->getCollection($class::getCollectionName())
            ->findOne(['id' => $id]);

        if (!$data) {
            return null;
        }

        $keys = (array) $class::getKeys();
        $array = [];
        foreach ($keys as $key) {
            $array[$key] = $data[$key];
        }

        try {
            $object = $this->hydrator->hydrate($class, $array);
        } catch (ReflectionException $exception) {
            return null;
        }

        if ($object) {
            return $object;
        }

        return null;
    }

    function getCustom(string $field, $value, string $class): ?Entity {
        $data = $this->conn
            ->getCollection($class::getCollectionName())
            ->findOne([$field => $value]);

        if (!$data) {
            return null;
        }

        $keys = (array) $class::getKeys();
        $array = [];
        foreach ($keys as $key) {
            $array[$key] = $data[$key];
        }

        try {
            $object = $this->hydrator->hydrate($class, $array);
        } catch (ReflectionException $exception) {
            return null;
        }

        if ($object) {
            return $object;
        }

        return null;
    }

    function add(Entity $object): bool {
        if ($this->isExist($object->getId(), $object->getClass())) {
            return false;
        }

        try {
            $id = $this->conn
                ->getCollection(get_class($object)::getCollectionName())
                ->insert($object->toArray());
        } catch (Exception $exception) {
            return false;
        }

        return $id != null;
    }

    function save(Entity $object): bool {
        if (!$this->isExist($object->getId(), $object->getClass())) {
            return false;
        }

        try {
            $flag = $this->conn
                ->getCollection(get_class($object)::getCollectionName())
                ->update(['id' => $object->getId()], $object->toArray());
        } catch (Exception $exception) {
            return false;
        }

        return $flag;
    }

    function remove(string $id, string $class): bool {
        if (!$this->isExist($id, $class)) {
            return false;
        }

        try {
            $flag = $this->conn
                ->getCollection($class::getCollectionName())
                ->remove(['id' => $id]);
        } catch (Exception $exception) {
            return false;
        }

        return $flag;
    }

    public function isExist(string $id, string $class): bool {
        return $this->get($id, $class) != null;
    }

}