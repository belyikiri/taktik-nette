<?php
declare(strict_types=1);

namespace App\UI\Presenter;

use App\Components\Forms\SurveyForm;
use App\Components\Grids\SurveyGridBuilder;
use Contributte\Application\UI\BasePresenter;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

class SurveyPresenter extends BasePresenter
{
    public function __construct(
        private readonly SurveyGridBuilder $surveyGridBuilder,
        private readonly SurveyForm $surveyForm,
    ) {
        parent::__construct();
    }

    public function createComponentSurveyGrid(): DataGrid
    {
        return $this->surveyGridBuilder->build();
    }

    public function createComponentSurveyForm(): Form
    {
        return $this->surveyForm->build($this);
    }
}
