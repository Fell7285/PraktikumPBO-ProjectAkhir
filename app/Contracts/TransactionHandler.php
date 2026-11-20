interface TransactionHandler
{
    public function handle(Account $source, array $data): Transaction;
}