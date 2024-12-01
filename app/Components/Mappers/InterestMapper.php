<?php

declare(strict_types=1);

namespace App\Components\Mappers;

use App\Models\Interest;

class InterestMapper
{
    /**
     * @param array{
     *      id: int,
     *      type: string,
     *      survey_id: string,
     *  } $row
     * @return Interest
     */
    public function map(array $row): Interest
    {
        $interest = new Interest();
        $interest->setId($row['id']);
        $interest->setType($row['type']);
        $interest->setSurveyId($row['survey_id']);

        return $interest;
    }
}
