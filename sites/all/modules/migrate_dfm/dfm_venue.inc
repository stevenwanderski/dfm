<?php

class DfmVenueMigration extends DfmMigration {
  public function __construct($arguments) {
    parent::__construct($arguments);

    $this->description = t('DFM venues');

    $query = Database::getConnection('default', 'legacy')->select('cms_venue', 'v');
    $query->fields('v');

    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('venue');
    $this->map = new MigrateSQLMap($this->machineName,
        array('id' => array(
              'type' => 'int',
              'not null' => TRUE,
              'description' => 'Venue ID.'
              )
        ),
        MigrateDestinationNode::getKeySchema()
    );

    $this->addFieldMapping('title', 'name');
    $this->addFieldMapping('field_address_1', 'address1');
    $this->addFieldMapping('field_address_2', 'address2');
    $this->addFieldMapping('field_city', 'city');
    $this->addFieldMapping('field_state', 'state');
    $this->addFieldMapping('field_zip', 'zip');
    $this->addFieldMapping('field_url', 'url');
    $this->addFieldMapping('status')
         ->defaultValue(1);

  }

}

?>