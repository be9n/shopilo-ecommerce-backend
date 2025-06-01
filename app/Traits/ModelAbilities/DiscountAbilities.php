<?php

namespace App\Traits\ModelAbilities;

trait DiscountAbilities
{
    use BaseAbilities;

    public function canBeDeleted(): array
    {
        if ($this->products()->exists()) {
            return $this->abilityFail(__('This discount cannot be deleted due to having products'));
        }

        return $this->abilitySuccess();
    }
}