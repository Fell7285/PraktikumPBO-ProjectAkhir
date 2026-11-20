enum AccountType: string
{
    case Savings = 'savings';
    case Current = 'current';

    public function rules(): AccountRules
    {
        return match ($this) {
            self::Savings => new SavingsRules(),
            self::Current => new CurrentRules(),
        };
    }
}