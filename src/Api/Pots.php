<?php

namespace Amelia\Monzo\Api;

use Ramsey\Uuid\Uuid;
use Amelia\Monzo\Models\Pot;

trait Pots
{
    /**
     * Get a user's pots.
     *
     * @return \Amelia\Monzo\Models\Pot[]|\Illuminate\Support\Collection
     */
    public function pots(string $currentAccountID)
    {
        $results = $this->call('GET', 'pots', [], [
            'current_account_id' => $currentAccountID,
        ], 'pots');

        return collect($results)->map(function ($item) {
            return new Pot($item, $this);
        });
    }

    /**
     * Get a pot by ID.
     *
     * @param string $id
     * @return \Amelia\Monzo\Models\Pot
     */
    public function pot(string $id)
    {
        $results = $this->call('GET', "pots/{$id}");

        return new Pot($results, $this);
    }

    /**
     * Fund a pot.
     *
     * @param string $id
     * @param int $amount
     * @param null|string $account
     * @param null|string $dedupeId
     * @return \Amelia\Monzo\Models\Pot
     */
    public function addToPot(string $id, int $amount, ?string $account = null, ?string $dedupeId = null)
    {
        $results = $this->call('PUT', "pots/{$id}/deposit", [], [
            'amount' => $amount,
            'source_account_id' => $account ?? $this->getAccountId(),
            'dedupe_id' => $dedupeId ?? (string) Uuid::uuid4(),
        ]);

        return new Pot($results, $this);
    }

    /**
     * Withdraw a given amount from a pot.
     *
     * @param string $id
     * @param int $amount
     * @param null|string $account
     * @param null|string $dedupeId
     * @return \Amelia\Monzo\Models\Pot
     */
    public function withdrawFromPot(string $id, int $amount, ?string $account = null, ?string $dedupeId = null)
    {
        $results = $this->call('PUT', "pots/{$id}/withdraw", [], [
            'amount' => $amount,
            'destination_account_id' => $account ?? $this->getAccountId(),
            'dedupe_id' => $dedupeId ?? (string) Uuid::uuid4(),
        ]);

        return new Pot($results, $this);
    }

    /**
     * Update a pot (e.g. the style).
     *
     * @param string $pot
     * @param array $attributes
     * @return \Amelia\Monzo\Models\Pot
     */
    public function updatePot(string $pot, array $attributes)
    {
        $results = $this->call('PATCH', "pots/{$pot}", [], $attributes);

        return new Pot($results, $this);
    }
}
