//ABSTRACT CLASS
abstract class AccountRules
{
    abstract public function minimumBalance(): int;
    abstract public function transferLimit(): int;

    public function canWithdraw(int $balance, int $amount): bool
    {
        return $balance - $amount >= $this->minimumBalance();
    }
}

// INHERITANCE
final class SavingsRules extends AccountRules
{
    public function minimumBalance(): int { return 50_000; }
    public function transferLimit(): int { return 10_000_000; }
}

final class CurrentRules extends AccountRules
{
    public function minimumBalance(): int { return 0; }
    public function transferLimit(): int { return 50_000_000; }
}