class EloquentTransactionRepository implements TransactionRepositoryInterface
{
    public function create(array $data): Transaction { return Transaction::create($data); }

    public function historyFor(int $accountId): Collection
    {
        return Transaction::where('account_id', $accountId)
            ->orWhere('destination_account_id', $accountId)
            ->latest()->get();
    }
}