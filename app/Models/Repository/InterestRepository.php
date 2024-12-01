<?php
declare(strict_types=1);

namespace App\Models\Repository;

use App\Components\Mappers\InterestMapper;
use App\Models\Exceptions\UpsertInterestException;
use App\Models\Interest;
use Nette\Database\Explorer;
use Throwable;

class InterestRepository
{
    public function __construct(
        private readonly Explorer $db,
        private readonly InterestMapper $mapper,
    ) {
    }

    /**
     * @param int $surveyId
     * @return Interest[]
     */
    public function getInterestsBySurveyId(int $surveyId): array
    {
        $serializedResult = [];
        $result = $this->db->table('survey_interest')->where('survey_id', $surveyId)->fetchAll();

        foreach ($result as $item) {
            /**
             * @var array{
             *      id: int,
             *      type: string,
             *      survey_id: string,
             *  } $row
             */
            $row = $item->toArray();
            $serializedResult[] = $this->mapper->map($row);
        }

        return $serializedResult;
    }

    /**
     * @throws Throwable
     */
    public function save(Interest $interest): ?int
    {
        $this->db->beginTransaction();

        try {
            $inserted = $this->db->table('survey_interest')->insert([
                'type' => $interest->getType(),
                'survey_id' => $interest->getSurveyId(),
            ]);

            $this->db->commit();

            return $inserted ? $inserted->getPrimary() : null;
        } catch (Throwable $exception) {
            $this->db->rollBack();

            throw new UpsertInterestException($exception->getMessage());
        }
    }
}
