<?php

namespace Attendance\Domain\Model\Account;

interface AccountRepository
{
    public function findById(AccountId $id): Account;
    public function store(Account $account): void;
}