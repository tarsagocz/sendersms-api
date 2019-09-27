<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 13:29 27.09.2019
 */

namespace Smswizz\Models\Campaign;

use Smswizz\Traits\HasManyTrait;

trait CampaignsTrait
{
    use HasManyTrait;
    /**
     * @var null|Campaign[]
     */
    protected $campaigns = null;
    /**
     * @var null|int
     */
    protected $count_campaign = null;

    public function campaignsGet($params = [], $refresh = false)
    {
        if (is_null($this->campaigns) || $refresh) {
            $this->campaigns = [];
            $array = $this->hasManyGet(Campaign::MODELS, $params);
            foreach ($array as $row) {
                $this->campaigns[] = Campaign::create($row);
            }
        }
        return $this->campaigns;
    }

    public function campaignsCount($params = [], $refresh = false)
    {
        if (is_null($this->count_campaign) || $refresh) {
            $this->count_campaign = $this->hasManyCount(Campaign::MODELS, $params);
        }
        return $this->count_campaign;
    }
}