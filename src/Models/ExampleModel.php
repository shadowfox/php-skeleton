<?php
namespace MyApp\Models;

class ExampleModel extends \Model {
    public static $_table = 'example';

    public function __toString() {
        return sprintf('ExampleModel[id=%s]', $this->id);
    }
}