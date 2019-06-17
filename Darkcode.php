<?php
/*
Plugin Name:        Darkcode
Description:        Plugin pour créer des tâche à partir d'un api
Version:            1
Author:             Les Darkcodeur
*/
//Documentation
include_once 'doc.php';
//Création de la Table darkcode
include_once 'classes/Database/Datable.php';
//Initialisation API
include_once 'classes/Api/Api.php';
//Route API
include_once 'classes/Api/Route.php';

/**
 * Class Darkcode
 */

class Darkcode
{
  public function __construct()
  {
    //Création d'un menu admin pour le plugin qui contiendra la DOC
    add_action( 'admin_menu', 'darkcode_doc_page' );
    add_action( 'init', [ $this, 'init' ] );
    register_activation_hook( __FILE__, [ $this, 'init_data' ] );
    register_deactivation_hook(__FILE__, [ $this, 'remove_data']);
  }

  public function init()
  {
  //Initialisation de l'API
   new Api();
  }
  //Création de la table darkcode à l'activation du plugin
  public function init_data()
  {
   new Datatable();
  }
  //Suppression de la table darkcode à la désactivation du plugin
  public function remove_data()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . "darkcode";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
  }
}
new Darkcode();