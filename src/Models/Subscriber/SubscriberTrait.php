<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 9:25 27.09.2019
 */

namespace Smswizz\Models\Subscriber;

use Smswizz\Traits\HasOneTrait;

trait SubscriberTrait
{
    use HasOneTrait;
    /**
     * @var null|Subscriber
     */
    protected $subscriber = null;

    public function subscriber($refresh = false)
    {
        if (is_null($this->subscriber) || $refresh) {
            $this->subscriber = Subscriber::create($this->hasOne(Subscriber::MODEL));
        }
        return $this->subscriber;
    }
}