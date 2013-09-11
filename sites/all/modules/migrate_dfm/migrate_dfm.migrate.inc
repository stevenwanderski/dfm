<?php
function migrate_dfm_migrate_api() {
  $api = array(
    'api' => 2,
    'groups' => array(
      'dfm' => array(
        'title' => t('DFM Migrations'),
      ),
    ),
    'migrations' => array(
      'DfmVenue' => array(
        'class_name' => 'DfmVenueMigration',
        'group_name' => 'dfm'
      ),
      'DfmShow' => array(
        'class_name' => 'DfmShowMigration',
        'group_name' => 'dfm'
      ),
    ),
  );
  return $api;
}
?>