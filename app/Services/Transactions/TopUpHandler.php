class TopUpHandler implements TransactionHandler
{
    public function __construct(private TransactionRepositoryInterface $transactions) {}

    public function handle(Account $source, array $data): Transaction
    {
        return DB::transaction(function () use ($source, $data) {
            $source->deposit((int) $data['amount']);
            return $this->transactions->create([
                'account_id' => $source->id,
                'type' => TransactionType::TopUp,
                'amount' => (int) $data['amount'],
                'description' => 'Top-up',
            ]);
        });
    }
}