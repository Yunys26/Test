<?php


namespace app\modules\api\repository;


use app\modules\api\models\Entity;

interface RepositoryInterface {

    // MARK: - Interface

    function get(string $id, string $class): ?Entity;

    function getCustom(string $field, $value, string $class): ?Entity;

    function add(Entity $object): bool;

    function save(Entity $object): bool;

    function remove(string $id, string $class): bool;

    function isExist(string $id, string $class): bool;

}