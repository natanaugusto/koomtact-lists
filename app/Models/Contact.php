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
        'franchise',
        'name',
        'telephone',
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
        $this->franchise = 'CVV';
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
}
