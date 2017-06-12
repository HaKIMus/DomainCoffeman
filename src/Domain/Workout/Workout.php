<?php

namespace Coffeeman\Domain\Workout;

use Coffeeman\Domain\Workout\Property\WorkoutProperty;
use Coffeeman\Domain\Workout\Type\WorkoutType;

class Workout
{
    private $id;

    private $workoutTypeId;

    private $workoutProperty;

    public function __construct(
        WorkoutType $typeId,
        WorkoutProperty $property
    ){
        $this->workoutTypeId = $typeId;
        $this->workoutProperty = $property;
    }
}
