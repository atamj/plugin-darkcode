<?php

class Datatable
{
    /**
     * Class Dataable pour créer la table Darkcode
     */
    public function __construct()
    {
        $this->database_init();
    }

    public function database_init()
    {
        if (empty($this->current_db_version)) {
            global $wpdb;
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            $sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "darkcode`(
                ID bigint(20) NOT NULL auto_increment,
                title varchar(255),
                description_tache varchar(255),
                state_tache varchar(255),
                user_id bigint(20),
                PRIMARY KEY  (`ID`)
            );";
            dbDelta( $sql );
        }
    }

}