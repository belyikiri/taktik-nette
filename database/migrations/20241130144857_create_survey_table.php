<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSurveyTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('survey', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'integer', ['length' => 11, 'signed' => false, 'identity' => true]);
        $table->addColumn('name', 'string', ['length' => 255, 'null' => false]);
        $table->addColumn('comment', 'string', ['length' => 255, 'null' => false]);
        $table->addColumn('is_agreed', 'boolean', ['null' => false, 'default' => false]);
        $table->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP']);
        $table->create();

        $table = $this->table('survey_interest', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'integer', ['length' => 11, 'signed' => false, 'identity' => true]);
        $table->addColumn('type', 'string', ['length' => 255, 'null' => false]);
        $table->addColumn('survey_id', 'integer', ['null' => false, 'length' => 11, 'signed' => false]);
        $table->addIndex('survey_id');
        $table->addForeignKey('survey_id', 'survey', 'id');
        $table->create();
    }
}
