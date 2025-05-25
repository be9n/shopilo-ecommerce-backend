<?php

namespace App\Traits\ModelAbilities;

use App\Exceptions\ModelAbilityException;

trait BaseAbilities
{
    /**
     * Return failure response for ability check.
     */
    protected function abilityFail(string $message): array
    {
        return [
            'message' => $message,
            'status' => false,
        ];
    }

    /**
     * Return success response for ability check.
     */
    protected function abilitySuccess(): array
    {
        return [
            'status' => true,
        ];
    }

    /**
     * Ensure the model has the specified ability.
     * 
     * @param string $ability The ability method name (e.g., 'canBeDeleted')
     * @throws ModelAbilityException When the ability check fails
     * @throws \InvalidArgumentException When the ability method doesn't exist
     */
    public function ensureAbility(string $ability, ...$args): void
    {
        if (!method_exists($this, $ability)) {
            throw new \InvalidArgumentException("Ability method '{$ability}' does not exist on " . static::class);
        }

        $result = $this->{$ability}(...$args);

        // Validate result structure
        if (!is_array($result) || !isset($result['status'])) {
            throw new \RuntimeException("Ability method '{$ability}' must return an array with 'status' key");
        }

        if (!$result['status']) {
            $message = $result['message'] ?? "Operation '{$ability}' is not allowed";
            throw new ModelAbilityException($message);
        }
    }
}