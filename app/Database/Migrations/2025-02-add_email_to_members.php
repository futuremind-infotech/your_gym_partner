<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToMembers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('members', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'contact'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('members', 'email');
    }
}
