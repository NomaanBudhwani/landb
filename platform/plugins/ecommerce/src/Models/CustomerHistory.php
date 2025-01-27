<?php

namespace Botble\Ecommerce\Models;

use Botble\ACL\Models\User;
use Botble\Base\Models\BaseModel;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerHistory extends BaseModel
{

    /**
     * @var string
     */
    protected $table = 'customer_histories';

    /**
     * @var array
     */
    protected $fillable = [
        'action',
        'description',
        'user_id',
        'customer_id',
        'extras',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault();
    }

    /**
     * @param string $value
     * @return array
     */
    public function getExtrasAttribute($value)
    {
        try {
            return json_decode($value, true) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }
}
