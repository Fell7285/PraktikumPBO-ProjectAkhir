class BillHandler implements TransactionHandler
{
    public function __construct(private TransactionRepositoryInterface $transactions) {}

    public function handle(Account $source, array $data): Transaction
    {
        return DB::transaction(function () use ($source, $data) {
            $source->withdraw((int) $data['amount']);
            return $this->transactions->create([
                'account_id' => $source->id,
                'type' => TransactionType::Bill,
                'amount' => (int) $data['amount'],
                'description' => 'Tagihan ' . ($data['bill_code'] ?? '-'),
            ]);
        });
    }
}