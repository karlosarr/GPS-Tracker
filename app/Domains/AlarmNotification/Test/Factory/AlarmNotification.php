<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class AlarmNotification extends FactoryAbstract
{
    /**
     * @var string
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => 'movement',

            'point' => Model::pointFromLatitudeLongitude(42.34818, -7.9126),

            'telegram' => false,

            'date_at' => date('Y-m-d H:i:s'),
            'date_utc_at' => date('Y-m-d H:i:s'),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'alarm_id' => $this->firstOrFactory(AlarmModel::class),
            'position_id' => $this->firstOrFactory(PositionModel::class),
            'trip_id' => $this->firstOrFactory(TripModel::class),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
