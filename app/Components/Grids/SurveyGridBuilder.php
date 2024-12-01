<?php
declare(strict_types=1);

namespace App\Components\Grids;

use App\Models\Repository\InterestRepository;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Ublaboo\DataGrid\DataGrid;

class SurveyGridBuilder
{
    public function __construct(
        private readonly Explorer $db,
        private readonly InterestRepository $interestRepository,
    ) {
    }

    public function build(): Datagrid
    {
        $grid = new Datagrid();
        $grid->setDataSource($this->db->table('survey'));
        $this->setColumns($grid);
        $this->setPagination($grid);
        $this->setOptions($grid);

        return $grid;
    }

    private function setColumns(DataGrid $grid): void
    {
        $grid->addColumnNumber('id', 'ID')
            ->setFitContent()
            ->setSortable()
            ->setFilterText()
            ->setExactSearch();
        $grid->addColumnText('name', 'Name')
            ->setFitContent()
            ->setSortable()
            ->setFilterText();
        $grid->addColumnText('comment', 'Comment')
            ->setFitContent()
            ->setFilterText();
        $grid->addColumnText('is_agreed', 'Is Agreed')
            ->setFitContent()
            ->setRenderer(function (ActiveRow $item) {
                return $item['is_agreed'] ? 'Yes' : 'No';
            })
            ->setFilterSelect([
                null => '---',
                true => 'Yes',
                false => 'No',
            ]);
        $grid->addColumnText('interests', 'Interests')
            ->setFitContent()
            ->setRenderer(function (ActiveRow $item) {
                $interests = [];
                foreach ($this->interestRepository->getInterestsBySurveyId((int)$item['id']) as $interest) {
                    $interests[] = $interest->getType();
                }

                return count($interests) ? implode(', ', $interests) : '---';
            });
        $grid->addColumnDateTime('created_at', 'Created at')
            ->setFitContent()
            ->setSortable()
            ->setFormat('j.n.Y H:i:s');
    }

    private function setPagination(DataGrid $grid): void
    {
        $grid->setItemsPerPageList([20, 50, 100]);
        $grid->setDefaultPerPage(20);
        $grid->setCustomPaginatorTemplate(__DIR__ . '/templates/pagination.latte');
    }

    private function setOptions(DataGrid $grid): void
    {
        $grid->setDefaultSort(['name' => 'ASC']);
        $grid->setAutoSubmit(false);
        $grid->setRememberState(true);
        $grid->addToolbarButton('Survey:edit', 'Survey')->setClass('button');
    }
}
