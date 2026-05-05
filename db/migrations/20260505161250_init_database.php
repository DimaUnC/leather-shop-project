<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitDatabase extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('categories');
        $table->addColumn('name', 'string', ['limit' => 100])
              ->addColumn('description', 'text', ['null' => true])
              ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();
    }
}