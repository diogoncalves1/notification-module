<?php
namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

// use Modules\Notification\Database\Factories\NotificationFactory;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'type_code', 'is_read', 'data', 'read_at'];

    protected $casts = [
        'data' => 'array',
    ];

    protected function user()
    {
        return $this->belogTo(User::class);
    }

    protected function notificationType()
    {
        return $this->belongsTo(NotificationType::class, 'type_code', 'code');
    }

    // protected static function newFactory(): NotificationFactory
    // {
    //     // return NotificationFactory::new();
    // }
}
