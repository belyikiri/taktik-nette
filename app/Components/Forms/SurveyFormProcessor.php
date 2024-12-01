<?php
declare(strict_types=1);

namespace App\Components\Forms;

use App\Models\Interest;
use App\Models\Repository\InterestRepository;
use App\Models\Repository\SurveyRepository;
use App\Models\Survey;
use Nette\Application\UI\Form;
use Throwable;

class SurveyFormProcessor
{
    public function __construct(
        private readonly SurveyRepository $surveyRepository,
        private readonly InterestRepository $interestRepository,
    ) {
    }

    public function process(Form $form): void
    {
        try {
            /** @var array $values */
            $values = (array)$form->getValues('array');

            $survey = new Survey();
            $survey->setName($values['name']);
            $survey->setComment($values['comment']);
            $survey->setIsAgreed((bool)$values['isAgreed']);
            $insertedId = $this->surveyRepository->save($survey);

            $interestTypes = (array)$values['interests'];
            foreach ($interestTypes as $interestType) {
                $interest = new Interest();
                $interest->setType(Interest::ALLOWED_INTERESTS[(int)$interestType]);
                $interest->setSurveyId($insertedId);
                $this->interestRepository->save($interest);
            }
        } catch (Throwable $exception) {
            $form->addError($exception->getMessage());
        }
    }
}
