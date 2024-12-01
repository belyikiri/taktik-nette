<?php
declare(strict_types=1);

namespace Tests\Unit\Components\Forms;

use App\Components\Forms\SurveyFormProcessor;
use App\Models\Repository\InterestRepository;
use App\Models\Repository\SurveyRepository;
use Nette\Application\UI\Form;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SurveyFormProcessorTest extends TestCase
{
    public function testCorrectProcess(): void
    {
        $surveyRepository = $this->mockSurveyRepository();
        $surveyRepository->expects($this->once())
            ->method('save');
        $surveyRepository->method('save')
            ->willReturn(1);

        $interestRepository = $this->mockInterestRepository();
        $interestRepository->expects($this->any())
            ->method('save');

        $processor = new SurveyFormProcessor($surveyRepository, $interestRepository);
        $processor->process($this->mockForm());
    }

    public function testIncorrectProcess(): void
    {
        $surveyRepository = $this->mockSurveyRepository();
        $surveyRepository->expects($this->never())
            ->method('save');

        $interestRepository = $this->mockInterestRepository();
        $interestRepository->expects($this->never())
            ->method('save');

        $processor = new SurveyFormProcessor($surveyRepository, $interestRepository);
        $processor->process($this->mockErrorForm());
    }

    private function mockForm(): Form
    {
        $mock = $this->getMockBuilder(Form::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getValues'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getValues')
            ->willReturn([
                'name' => 'Test name',
                'comment' => 'Test comment',
                'isAgreed' => true,
                'interests' => [0, 1],
            ]);

        /* @var Form $mock */
        return $mock;
    }

    private function mockErrorForm(): Form
    {
        $mock = $this->getMockBuilder(Form::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getValues'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getValues')
            ->willReturn([
                'name' => 1
            ]);

        /* @var Form $mock */
        return $mock;
    }

    private function mockSurveyRepository(): MockObject&SurveyRepository
    {
        return $this->getMockBuilder(SurveyRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['save'])
            ->getMock();
    }

    private function mockInterestRepository(): MockObject&InterestRepository
    {
        return $this->getMockBuilder(InterestRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['save'])
            ->getMock();
    }
}
