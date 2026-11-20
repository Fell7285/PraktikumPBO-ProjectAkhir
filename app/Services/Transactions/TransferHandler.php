class TransferHandler implements TransactionHandler
{
    public function __construct(
        private AccountRepositoryInterface $accounts,
        private TransactionRepositoryInterface $transactions,
    ) {}

    public function handle(Account $source, array $data): Transaction
    {
        $amount = (int) $data['amount'];
        $dest = $this->accounts->findByNumber($data['destination_account_number'])
            ?? throw new BusinessRuleException('Rekening tujuan tidak ditemukan');

        if ($dest->id === $source->id) throw new BusinessRuleException('Rekening tujuan tidak boleh sama');
        if ($amount > $source->rules()->transferLimit()) throw new BusinessRuleException('Melebihi batas transfer');

        return DB::transaction(function () use ($source, $dest, $amount, $data) {
            $locked = $this->accounts->lockPair($source->id, $dest->id);
            $locked[$source->id]->withdraw($amount);
            $locked[$dest->id]->deposit($amount);

            return $this->transactions->create([
                'account_id' => $source->id,
                'destination_account_id' => $dest->id,
                'type' => TransactionType::Transfer,
                'amount' => $amount,
                'description' => $data['description'] ?? null,
            ]);
        });
    }
}