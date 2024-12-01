<?php
declare(strict_types=1);

namespace App\Models\Repository;

use App\Models\Exceptions\UpsertSurveyException;
use App\Models\Survey;
use Nette\Database\Explorer;
use Throwable;

class SurveyRepository
{
    public function __construct(
        private readonly Explorer $db,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function save(Survey $survey): ?int
    {
        $this->db->beginTransaction();

        try {
            $inserted = $this->db->table('survey')->insert([
                'name' => $survey->getName(),
                'comment' => $survey->getComment(),
                'is_agreed' => $survey->isAgreed(),
            ]);

            $this->db->commit();

            return $inserted->getPrimary();
        } catch (Throwable $exception) {
            $this->db->rollBack();

            throw new UpsertSurveyException($exception->getMessage());
        }
    }
}
