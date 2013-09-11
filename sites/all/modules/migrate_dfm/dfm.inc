<?php

abstract class DfmMigration extends Migration {
  public function __construct($arguments) {
    parent::__construct($arguments);

    $this->team = array(
      new MigrateTeamMember('Steven Wanderski', 'steven@bxcreative.com', t('Lead Programmer'))
    );
  }
}

?>