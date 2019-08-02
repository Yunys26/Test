<?php


namespace app\modules\api\models;


use Faker\Provider\Uuid;

class RandomObject implements Entity {

    // MARK: - Properties

    private $id;
    private $requestId;
    private $value;
    private $type;

    // MARK: - Init

    public function __construct(string $requestId, string $value, string $type) {
        $this->id = Uuid::uuid();
        $this->requestId = $requestId;
        $this->value = $value;
        $this->type = $type;
    }

    // MARK: - Static

    static public function getCollectionName(): string {
        return 'random';
    }

    static public function getKeys(): array {
        return ['id', 'requestId', 'value', 'type'];
    }

    // MARK: - Interface

    public function getClass(): string {
        return self::class;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getRequestId(): string {
        return $this->requestId;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'requestId' => $this->requestId,
            'value' => $this->value,
            'type' => $this->type
        ];
    }



}