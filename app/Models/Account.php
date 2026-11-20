<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    // 'balance' sengaja TIDAK masuk fillable → tidak bisa diisi massal
    protected $fillable = ['user_id', 'account_number', 'type'];
    protected $casts = ['type' => AccountType::class];

    public function rules(): AccountRules { return $this->type->rules(); }

    public function deposit(int $amount): void
    {
        if ($amount <= 0) throw new BusinessRuleException('Nominal harus lebih dari 0');
        $this->balance += $amount;
        $this->save();
    }

    public function withdraw(int $amount): void
    {
        if ($amount <= 0) throw new BusinessRuleException('Nominal harus lebih dari 0');
        if (!$this->rules()->canWithdraw($this->balance, $amount)) {
            throw new BusinessRuleException('Saldo tidak mencukupi');
        }
        $this->balance -= $amount;
        $this->save();
    }

    public function user() { return $this->belongsTo(User::class); }
}

// app/Models/Transaction.php
class Transaction extends Model
{
    protected $fillable = ['account_id', 'destination_account_id', 'type', 'amount', 'description'];
    protected $casts = ['type' => TransactionType::class];
}
