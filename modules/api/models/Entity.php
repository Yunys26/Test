<?php


namespace app\modules\api\models;


interface Entity {

    // MARK: - Interface

    static function getCollectionName(): string;
    static function getKeys(): array;

    function getClass(): string;

    function getId(): string;

    function toArray(): array;

}