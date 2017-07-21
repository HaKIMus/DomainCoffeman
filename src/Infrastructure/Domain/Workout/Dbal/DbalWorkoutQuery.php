<?php
/**
 * Created by PhpStorm.
 * User: webdevhakim
 * Date: 28.03.17
 * Time: 23:00
 */

namespace Coffeeman\Infrastructure\Domain\Workout\Dbal;

use Coffeeman\Application\Query\WorkoutQueryInterface;
use Coffeeman\Application\Query\Workout\WorkoutView;
use Coffeeman\Infrastructure\Domain\AbstractDBALQuery;

class DbalWorkoutQuery extends AbstractDBALQuery implements WorkoutQueryInterface
{
    public function getById(int $id): WorkoutView
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('w.sportsmanId',
                'w.workoutTypeId',
                'w.workoutPropertyId',
                'wType.name',
                'wProperty.workoutBurnedCalories',
                'wProperty.workoutStartDate',
                'wProperty.workoutStopDate')
            ->from('workout', 'w')
            ->innerJoin('w', 'workoutType', 'wType', 'wType.id = w.workoutTypeId')
            ->innerJoin('w', 'workoutProperty', 'wProperty', 'wProperty.id = w.workoutPropertyId')
            ->where('w.id = :id')
            ->setParameter('id', $id);

        $workoutData = $this->connection->fetchAssoc($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return new WorkoutView(
            $workoutData['sportsmanId'],
            $workoutData['workoutTypeId'],
            $workoutData['workoutPropertyId'],
            $workoutData['name'],
            $workoutData['workoutBurnedCalories'],
            $workoutData['workoutStartDate'],
            $workoutData['workoutStopDate']
        );
    }

    public function getAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('w.sportsmanId',
                'w.workoutTypeId',
                'w.workoutPropertyId',
                'wType.name',
                'wProperty.workoutBurnedCalories',
                'wProperty.workoutStartDate',
                'wProperty.workoutStopDate')
            ->from('workout', 'w')
            ->innerJoin('w', 'workoutType', 'wType', 'wType.id = w.workoutTypeId')
            ->innerJoin('w', 'workoutProperty', 'wProperty', 'wProperty.id = w.workoutPropertyId');

        $workoutsData = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return array_map(function(array $workoutData) {
            return new WorkoutView(
                $workoutData['sportsmanId'],
                $workoutData['workoutTypeId'],
                $workoutData['workoutPropertyId'],
                $workoutData['name'],
                $workoutData['workoutBurnedCalories'],
                $workoutData['workoutStartDate'],
                $workoutData['workoutStopDate']
            );
        }, $workoutsData);
    }

    public function getAllWorkoutsBySportsmanId(int $sportsmanId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('w.sportsmanId',
                'w.workoutTypeId',
                'w.workoutPropertyId',
                'wType.name',
                'wProperty.workoutBurnedCalories',
                'wProperty.workoutStartDate',
                'wProperty.workoutStopDate')
            ->from('workout', 'w')
            ->innerJoin('w', 'workoutType', 'wType', 'wType.id = w.workoutTypeId')
            ->innerJoin('w', 'workoutProperty', 'wProperty', 'wProperty.id = w.workoutPropertyId')
            ->where('w.sportsmanId = :sportsmanId')
            ->setParameter('sportsmanId', $sportsmanId);

        $workoutsData = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return array_map(function(array $workoutData) {
            return new WorkoutView(
                $workoutData['sportsmanId'],
                $workoutData['workoutTypeId'],
                $workoutData['workoutPropertyId'],
                $workoutData['name'],
                $workoutData['workoutBurnedCalories'],
                $workoutData['workoutStartDate'],
                $workoutData['workoutStopDate']
            );
        }, $workoutsData);
    }

    public function getBySportsmanIdMostPopularWorkoutType(int $sportsmanId)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('w.workoutTypeId',
                'COUNT(w.workoutTypeId) AS mostPopularWorkoutType',
                'wType.id',
                'wType.name')
            ->from('workout', 'w')
            ->innerJoin('w', 'workoutType', 'wType', 'wType.id = w.workoutTypeId')
            ->where('w.sportsmanId = :sportsmanId')
            ->groupBy('w.workoutTypeId')
            ->orderBy('mostPopularWorkoutType', 'DESC')
            ->setMaxResults(1)
            ->setParameter('sportsmanId', $sportsmanId);

        $workoutData = $this->connection->fetchAssoc($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return new WorkoutView(
            0,
            $workoutData['workoutTypeId'],
            0,
            $workoutData['name']
        );
    }
}
