<?php declare(strict_types=1);

namespace App\Domains\Device\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Collection\Device as Collection;
use App\Domains\Device\Model\Device as Model;

class Map extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->request->merge([
            'user_id' => $this->auth->preference('user_id', $this->request->input('user_id')),
            'vehicle_id' => $this->auth->preference('vehicle_id', $this->request->input('vehicle_id')),
        ]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCore() + [
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'vehicle_empty' => $this->vehicleEmpty(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->whenIds($this->requestArray('ids'))
                ->whenTripFinished($this->requestBool('finished'))
                ->withUser()
                ->withVehicle()
                ->withWhereHasPositionLast()
                ->list()
                ->get()
        );
    }
}
