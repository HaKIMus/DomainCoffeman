<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 16.04.17
 * Time: 16:16
 */

namespace Coffeeman\Application\Command;

class CreateNewWorkout
{
    private $sportsmanId;
    private $workoutTypeId;
    private $burnedCalories;
    private $startDate;
    private $stopDate;

    public function __construct(
        string $sportsmanId,
        int $typeId,
        int $burnedCalories,
        \DateTime $startDate,
        \DateTime $stopDate
    ){
        $this->sportsmanId = $sportsmanId;
        $this->workoutTypeId = $typeId;
        $this->burnedCalories = $burnedCalories;
        $this->startDate = $startDate;
        $this->stopDate = $stopDate;
    }

    public function getSportsmanId(): string
    {
        return $this->sportsmanId;
    }

    public function getWorkoutTypeId(): int
    {
        return $this->workoutTypeId;
    }

    public function getBurnedCalories(): int
    {
        return $this->burnedCalories;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function getStopDate(): \DateTime
    {
        return $this->stopDate;
    }
}
