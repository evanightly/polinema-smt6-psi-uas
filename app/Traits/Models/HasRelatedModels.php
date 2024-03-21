<?php

namespace App\Traits\Models;

trait HasRelatedModels {
    public function hasRelatedModels(array $models) {
        foreach ($models as $model) {
            if (method_exists($this, $model) && $this->$model()->exists()) {
                return true;
            }
        }

        return false;
    }
}
