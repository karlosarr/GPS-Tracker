<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\Device\Model\Device as DeviceModel;

class DeviceMessage extends BuilderAbstract
{
    /**
     * @param string $serial
     *
     * @return self
     */
    public function byDeviceSerial(string $serial): self
    {
        return $this->whereIn('device_id', DeviceModel::select('id')->bySerial($serial));
    }

    /**
     * @param bool $sent_at = false
     *
     * @return self
     */
    public function whereSentAt(bool $sent_at = false): self
    {
        return $this->when($sent_at, static fn ($q) => $q->whereNotNull('sent_at'), static fn ($q) => $q->whereNull('sent_at'));
    }
}