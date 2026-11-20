interface AccountRepositoryInterface
{
    public function create(array $data): Account;
    public function forUser(int $userId): Collection;
    public function findByNumber(string $number): ?Account;
    public function lockPair(int $idA, int $idB): Collection;   // keyed by id
}

// app/Contracts/TransactionRepositoryInterface.php
interface TransactionRepositoryInterface
{
    public function create(array $data): Transaction;
    public function historyFor(int $accountId): Collection;
}