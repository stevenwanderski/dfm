<?php

class DfmShowMigration extends DfmMigration {
  public function __construct($arguments) {
    parent::__construct($arguments);

    $this->description = t('DFM venues');

    $query = Database::getConnection('default', 'legacy')->select('cms_show', 's');
    $query->fields('s');

    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('show');
    $this->map = new MigrateSQLMap($this->machineName,
        array('id' => array(
              'type' => 'int',
              'not null' => TRUE,
              'description' => 'Show ID.'
              )
        ),
        MigrateDestinationNode::getKeySchema()
    );

    $this->addFieldMapping('title')
         ->defaultValue('DFM show');
    $this->addFieldMapping('field_venue', 'venue_id')
         ->sourceMigration('DfmVenue');
    $this->addFieldMapping('field_date', 'date');
    $this->addFieldMapping('field_time', 'time');
    $this->addFieldMapping('field_message', 'message');
    $this->addFieldMapping('status')
         ->defaultValue(1);

  }

}

?>