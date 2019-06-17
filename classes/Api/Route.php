<?php

class Routes
{

    /**
     * Class Route
     */
    public function __construct()
    {
    	$this->create_task_routes();
    }

    public function create_task_routes()
    {
    	//Enregistrement de la route GET
        register_rest_route('darkcode/v1', '/tasks/(?P<id>\d+)', array(
    		'methods' => 'GET',
    		'callback' => [$this,"get_with_id"],
    	));
        //Enregistrement de la route GET All
    	register_rest_route('darkcode/v1', '/tasks', array(
    		'methods' => 'GET',
    		'callback' => [$this,"get_all"],
    	));
        //Enregistrement de la route POST
    	register_rest_route('darkcode/v1', '/tasks', array(
    		'methods' => 'POST',
    		'callback' => [$this,"create"],
    	));
        //Enregistrement de la route PUT
    	register_rest_route('darkcode/v1', '/tasks/(?P<id>\d+)', array(
    		'methods' => 'PUT',
    		'callback' => [$this,"update"],
    	));
        //Enregistrement de la route DELETE
    	register_rest_route('darkcode/v1', '/tasks/(?P<id>\d+)', array(
    		'methods' => 'DELETE',
    		'callback' => [$this,"delete"],
    	));
        //Enregistrement de la route GET users
        register_rest_route('darkcode/v1', '/users', array(
            'methods' => 'GET',
            'callback' => [$this,"get_users"],
        ));
        //Enregistrement de la route GET documentation
        register_rest_route('darkcode/v1', '/doc', array(
            'methods' => 'GET',
            'callback' => [$this,"doc"],
        ));
    	
    }
    //Fonction pour la route GET
    public function get_all()
    {
    	global $wpdb;
        $table_name = $wpdb->prefix . "darkcode";
        $table_darkcode = $wpdb->get_results( "SELECT * FROM $table_name" );

        return rest_ensure_response($table_darkcode);
    }
    //Fonction pour la route GET par ID
    public function get_with_id($data)
    {

        global $wpdb;
        $table_name = $wpdb->prefix . "darkcode";
        $tache = $wpdb->get_row( $wpdb->prepare( 
            "
                SELECT *
                FROM $table_name 
                WHERE ID = %s
            ", 
            $data['id']
        ) );

        return rest_ensure_response($tache);

    }
    //Fonction pour la route POST
    public function create($data)
    {
        //On récupère les données de $_POST dans $req
        $req = $data->get_params();

        global $wpdb;
        $table_name = $wpdb->prefix . "darkcode";
        //On vérifie si toutes les clés sont présentent
        if (array_key_exists('title',$req) && 
            array_key_exists('description_tache',$req) &&
            array_key_exists('state_tache',$req) &&
            array_key_exists('user',$req)
        ) 
        {

            //Requette SQL INSERT
            $wpdb->insert($table_name,[
                'title' => $req["title"],
                'description_tache' => $req["description_tache"],
                'state_tache' => $req["state_tache"],
                'user_id' => $req["user"]
                ],
                ['%s','%s','%s','%d'] 
            );
        }
        //On retourne les données du $_POST pour un éventuelle débogage
        return rest_ensure_response(json_encode($req));
        
    }
    //Fonction pour la route PUT
    public function update($data)
    {
        //On récupère l'id passé en paramètre dans l'url
        $post_id = $data['id'];

        //On récupère les données de $_POST dans $data
        $data = $data->get_params();
        global $wpdb;
        $table_name = $wpdb->prefix . "darkcode";
        //On vérifie si toutes les clés sont présentent
        if (array_key_exists('title',$data) && 
            array_key_exists('description_tache',$data) &&
            array_key_exists('state_tache',$data) &&
            array_key_exists('user',$data)
        ) 
        {

            //Requette SQL UPDATE
            $wpdb->update($table_name,[
               'title' => $data["title"],
               'description_tache' => $data["description_tache"],
               'state_tache' => $data["state_tache"],
               'user_id' => $data["user"]
                ],
                ['ID' => $post_id],
                ['%s','%s','%s','%d'],
                ['%d']
            );
        }
        //On retourne les données du $_POST pour un éventuelle débogage
        return json_encode($data);
    }
    //Fonction pour la route DELETE
    public function delete($data)
    {
        //On récupère l'id passé en paramètre dans l'url
        $post_id = $data['id'];
        global $wpdb;
        $table_name = $wpdb->prefix . "darkcode";

        //Requette SQL UPDATE
        $wpdb->delete($table_name,['ID' => $post_id]);

        //Message pour informé que la requette a fonctionnée
        return "OK";

    }
    //Fonction pour la route GET USERS
    public function get_users()
    {
        //Fonction WP pour récupérer la liste des USERS
        $users = get_users([
            'orderby'=>'nicename',
            'order'=> 'ASC']);
        $res = [];
        //On boucle sur la liste des users pour filtré les information à renvoyer
        foreach ($users as $user) 
        {
            //On enregistre dans une variable les informations qu'on veux garder
            $data = $user->data;
            $id = $data->ID;
            $display_name = $data->display_name;
            $user_email = $data->user_email;
            $user_login = $data->user_login;
            $caps = $user->caps;
            //On crée un nouveau tableau user avec les informations filtré
            $user = [
                "ID" => $id,
                "display_name" => $display_name,
                "user_email" => $user_email,
                "user_login" => $user_login,
                "caps" => $caps
            ];
            //On enregistre les infos de chaque user dans le même tableau
            array_push($res,$user);

        }

        return rest_ensure_response($res);
    }
    //Fonction pour la route GET DOC
    public function doc()
    {
        //On renvoi la doc en sous forme de tableau qui sera convertie en JSON
        return rest_ensure_response(
        [
            "Documentation"=>[
                "GET"=> "<site url>/wp-json/darkcode/v1/tasks/",
                "POST"=>[
                    "URL"=> "<site url>/wp-json/darkcode/v1/tasks/",
                    "Keys"=> ["title", "description_tache", "state_tache", "user (id)"]
                ],
                "PUT"=> [
                    "URL"=> "<site url>/wp-json/darkcode/v1/tasks/<id task>",
                    "Keys"=> ["title", "description_tache", "state_tache", "user (id)"]
                ],
                "DELETE"=> "<site url>/wp-json/darkcode/v1/tasks/<id task>",
                "GET_USERS"=> "<site url>/wp-json/darkcode/v1/users/",
                "GET_DOC"=> "<site url>/wp-json/darkcode/v1/doc/"
            ]
        ]
       );
    }
    
}