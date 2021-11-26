<?php

namespace App\Models;

use App\Contracts\Validatable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LVR\CreditCard\CardNumber;

/**
 * @property User $user
 * @see Contact::user()
 * @property string $credit_card
 * @see Contact::setCreditCardAttribute()
 */
class Contact extends Model implements Validatable
{
    use HasFactory;

    protected $fillable = [
        'address',
        'birthday',
        'credit_card',
        'email',
        'name',
        'telephone',
    ];

    protected array $franchiseRegex = [
        '/^34|37/' => 'American Express',
        '/^36/' => 'Diners Club International',
        '/^6011|[644-649]|65/' => 'Discover Card',
        '/^[3528-3589]/' => 'JCB',
        '/^[2221-2720]|[51–55]/' => 'Mastercard',
    ];

    public static function rules(): array
    {
        return [
            'name' => [
                'required',
                ['regex' => '/^[a-zA-Z \-]*$/'],
            ],
            'birthday' => [
                'required',
                ['date_format' => DateTimeInterface::ISO8601]
            ],
            'telephone' => [
                'required',
                ['regex' => '/^\(\+[0-9]{2,3}\)( +[0-9]{3}){2}( +[0-9]{2}){2,3}$/']
            ],
            'address' => [
                'required'
            ],
            'credit_card' => [
                'required',
                new CardNumber()
            ],
            'email' => [
                'required',
                'email',
            ]
        ];
    }

    public static function messages(): array
    {
        return [];
    }


    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->franchise = $this->getCreditCardFranchise($this->credit_card);
        return parent::save($options);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $value
     */
    public function setCreditCardAttribute($value)
    {
        $this->attributes['credit_card'] = str_replace(' ', '', $value);
    }

    /**
     * @param string $credit_card
     * @return string
     */
    private function getCreditCardFranchise(string $credit_card): string
    {
        foreach ($this->franchiseRegex as $regex => $franchise) {
            if (preg_match($regex, $credit_card)) {
                return $credit_card;
            }
        }
        return '-';
    }
}
