<?php
declare(strict_types=1);

namespace App\Models;

class Interest
{
    private int $id;
    private string $type;
    private int $surveyId;

    private const INTEREST_A = 'interest_a';
    private const INTEREST_B = 'interest_b';
    private const INTEREST_C = 'interest_c';
    public const ALLOWED_INTERESTS = [
        self::INTEREST_A,
        self::INTEREST_B,
        self::INTEREST_C,
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getSurveyId(): int
    {
        return $this->surveyId;
    }

    public function setSurveyId(int $surveyId): void
    {
        $this->surveyId = $surveyId;
    }
}
