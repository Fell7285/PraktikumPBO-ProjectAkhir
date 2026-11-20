class TransactionService
{
    /** @param array<string, TransactionHandler> $handlers */
    public function __construct(private array $handlers) {}

    public function execute(TransactionType $type, Account $source, array $data): Transaction
    {
        $handler = $this->handlers[$type->value]
            ?? throw new BusinessRuleException('Jenis transaksi tidak didukung');
        return $handler->handle($source, $data);
    }
}