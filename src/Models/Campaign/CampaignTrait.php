<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 13:17 27.09.2019
 */

namespace Smswizz\Models\Campaign;

use Smswizz\Traits\HasOneTrait;

trait CampaignTrait
{
    use HasOneTrait;
    /**
     * @var null|Campaign
     */
    protected $campaign = null;

    public function campaign($refresh = false)
    {
        if (is_null($this->campaign) || $refresh) {
            if (is_null($row = $this->hasOne(Campaign::MODEL))) {
                return null;
            }
            $this->campaign = Campaign::create($row);
        }
        return $this->campaign;
    }
}