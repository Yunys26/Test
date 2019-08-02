<?php

class m190725_191737_init extends \yii\mongodb\Migration
{
    public function up() {
        $this->createCollection("random");
    }

    public function down() {
        $this->remove("random");
    }
}
