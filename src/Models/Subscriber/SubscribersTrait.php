<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 9:23 27.09.2019
 */

namespace Smswizz\Models\Subscriber;

use Smswizz\Traits\HasManyTrait;

trait SubscribersTrait
{
    use HasManyTrait;
    /**
     * @var null|Subscriber[]
     */
    protected $subscribers = null;
    /**
     * @var null|int
     */
    protected $count_subscriber = null;

    public function subscribersGet($params = [], $refresh = false)
    {
        if (is_null($this->subscribers) || $refresh) {
            $this->subscribers = [];
            $array = $this->hasManyGet(Subscriber::MODELS, $params);
            foreach ($array as $row) {
                $this->subscribers[] = Subscriber::create($row);
            }
        }
        return $this->subscribers;
    }

    public function subscribersCount($params = [], $refresh = false)
    {
        if (is_null($this->count_subscriber) || $refresh) {
            $this->count_subscriber = $this->hasManyCount(Subscriber::MODELS, $params);
        }
        return $this->count_subscriber;
    }
}