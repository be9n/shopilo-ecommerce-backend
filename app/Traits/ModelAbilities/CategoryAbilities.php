<?php

namespace App\Traits\ModelAbilities;

trait CategoryAbilities
{
    use BaseAbilities;

    public function canBeDeleted(): array
    {
        if ($this->isParent() && $this->children()->exists()) {
            return $this->abilityFail(__('This category cannot be deleted due to having children'));
        }

        if ($this->products()->exists()) {
            return $this->abilityFail(__('This category cannot be deleted due to having products'));
        }

        return $this->abilitySuccess();
    }
}