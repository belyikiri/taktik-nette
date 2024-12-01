<?php
declare(strict_types=1);

namespace App\Components\Forms;

use App\Models\Interest;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class SurveyForm extends Control
{
    private const MAX_LENGTH = 255;

    public function __construct(
        private readonly SurveyFormProcessor $processor,
    ) {
    }

    public function build(Presenter $presenter): Form
    {
        $form = new Form();
        $form->addHidden('id');
        $form->addText('name', 'Name')
            ->setRequired()
            ->setHtmlAttribute('maxlength', self::MAX_LENGTH);
        $form->addTextArea('comment', 'Comment')
            ->setRequired()
            ->setHtmlAttribute('rows', 5)
            ->setHtmlAttribute('maxlength', self::MAX_LENGTH);
        $form->addMultiSelect('interests', 'Interests', Interest::ALLOWED_INTERESTS);
        $form->addCheckbox('isAgreed', 'Are you agree with terms?')
            ->setRequired();
        $form->addSubmit('save', 'Save');

        $form->onValidate[] = function (Form $form) use ($presenter): void {
            $this->validateFields($form);
            if ($form->hasErrors()) {
                foreach ($form->getErrors() as $error) {
                    $presenter->flashMessage($error, 'error');
                }
                $presenter->redirect('this');
            }
        };

        $form->onSuccess[] = function (Form $form) use ($presenter): void {
            $this->processor->process($form);
            if ($form->hasErrors()) {
                foreach ($form->getErrors() as $error) {
                    $presenter->flashMessage($error, 'error');
                }
                $presenter->redirect('this');
            }

            $presenter->flashMessage('DONE', 'success');
            $presenter->redirect('Survey:default');
        };

        return $form;
    }

    private function validateFields(Form $form): void
    {
        $values = (array)$form->getValues('array');
        if (!preg_match('/^[a-zA-Z -]+$/', $values['name'])) {
            $form->addError('Name can contain only letters and spaces.');
        }
    }
}
