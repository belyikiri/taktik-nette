<?php
declare(strict_types=1);

namespace Tests\Unit\Components\Forms;

use App\Components\Forms\SurveyForm;
use App\Components\Forms\SurveyFormProcessor;
use Nette\Application\UI\Form;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SurveyFormValidatorTest extends TestCase
{
    public function testCorrectValidation(): void
    {
        $surveyFormProcessor = $this->mockSurveyFormProcessor();
        $formBuilder = new SurveyForm($surveyFormProcessor);
        $formBuilder->validateFields($this->mockForm());
    }

    public function testIncorrectValidation(): void
    {
        $surveyFormProcessor = $this->mockSurveyFormProcessor();
        $formBuilder = new SurveyForm($surveyFormProcessor);

        $mockForm = $this->mockForm(false);
        $formBuilder->validateFields($mockForm);
        Assert::assertTrue($mockForm->hasErrors());
    }

    private function mockForm(bool $isCorrect = true): Form
    {
        $mock = $this->getMockBuilder(Form::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getValues'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getValues')
            ->willReturn([
                'name' => $isCorrect ? 'Test name' : '12345',
            ]);

        /* @var Form $mock */
        return $mock;
    }

    private function mockSurveyFormProcessor(): MockObject&SurveyFormProcessor
    {
        return $this->getMockBuilder(SurveyFormProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
