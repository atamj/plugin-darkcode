<?php
function darkcode_doc_page() 
{
  add_menu_page(
    'Darkcode',
    'Darkcode Doc',
    'manage_options',
    'darkcode',
    'darkcode_doc_html',
    'dashicons-welcome-write-blog',
    20
  );
}
function darkcode_doc_html() 
{
  // check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) 
  {
    return;
  }
  //Récupère la liste des utilisateurs
  $users = get_users(['orderby'=>'nicename','order'=> 'ASC']);
  require_once "css/style.php";
  ?>
    <div class ="wrap">
      <h1>Documentation</h1>
      <p>
        <a href="<?= site_url() ?>/wp-content/plugins/darkcode/documentation.pdf">Documentation PDF</a>
      </p>
      <p>URL API: <a target="blank_" href="<?= site_url() ?>/wp-json/darkcode/v1/tasks/"><?= site_url() ?>/wp-json/darkcode/v1/tasks/</a></p>
      <p>
        URL liste des utilisateurs: <a target="blank_" href="<?= site_url() ?>/wp-json/darkcode/v1/users/"><?= site_url() ?>/wp-json/darkcode/v1/users/</a>
      </p>
      <p>
        Retourne un tableau JSON
        <pre>
          [
              {
                  "ID": "1",
                  "display_name": "Name 1",
                  "user_email": "email@mail.com",
                  "user_login": "login",
                  "caps": {
                      "editor": true
                  }
              },
              {
                  "ID": "2",
                  "display_name": "Name 2",
                  "user_email": "email@mail.com",
                  "user_login": "login",
                  "caps": {
                      "administrator": true
                  }
              }
          ]
        </pre>
      </p>
      <p>
        Documentation simplifié en JSON: <a target="blank_" href="<?= site_url() ?>/wp-json/darkcode/v1/doc/"><?= site_url() ?>/wp-json/darkcode/v1/doc/</a>
      </p>
      <p>
        Pour utiliser les ressources de l'Api utilisez l'URL ci-dessus.
      </p>
      <ul>
        <li>
          Pour récupérer toutes les tâches faire une GET sur l'URL
          <pre>
            axios({
              method: 'get',
              url: url
            })
            .then( (response)=> {
              let data = response.data
              console.log(data)
            });
          </pre>
        </li>
        <li>
          Pour récupérer ajouter un tâche faire un POST sur l'URL et utilisant les clés suivantes :
          <ul>
            <li>
              title (le titre de la tâche)
            </li>
            <li>
              description_tache (description de la tâche)
            </li>
            <li>
              state_tache (À  faire, en cours, terminée)
            </li>
            <li>
              user (L'ID de l'utilisateur attribué à la tâche)
            </li>
          </ul>
          <pre>
            axios({
              method: 'post',
                  url: url,
                  data: {
                    title: "Mon titre",
                    description_tache: "Ma description",
                    state_tache: "L'avancement de la tâche",
                    user: "L'user ID"
                  }
              });
          </pre>
        </li>
        <li>
          Pour modifier une tâche faire un PUT sur l'URL en rajoutant l'ID de la tâche à modifier en utilisant les clés suivantes :
          <ul>
            <li>
              title (le titre de la tâche)
            </li>
            <li>
              description_tache (description de la tâche)
            </li>
            <li>
              state_tache (À  faire, en cours, terminée)
            </li>
            <li>
              user (L'ID de l'utilisateur attribué à la tâche)
            </li>
          </ul>
          <pre>
            axios({
              method: 'put',
              url: url+id,
                data: {
                title: "Mon titre",
                description_tache: "Ma description",
                state_tache: "L'avancement de la tâche",
                user: "L'user ID"
                }
            });
          </pre>
        </li>
        <li>
          Pour supprimer une tâche faire un DELETE sur l'URL en rajoutant l'ID de la tâche à supprimer.
          <pre>
            axios.delete(url+id)
          </pre>
        </li>
      </ul>
      <h2>Ajouter une tâches</h2>
      <form id="post" action="<?= site_url() ?>/wp-json/darkcode/v1/tasks/" >
        <div>
          <label for="title">Title</label>
          <input type="text" name="title" id="title">
        </div>
        <div>
          <label for="description_tache">Description</label>
          <input type="text" name="description_tache" id="description_tache">
        </div>
        <div>
          <label for="state_tache"></label>
          <select name="state_tache" id="state_tache">
            <option value="À faire">
              À faire
            </option>
            <option value="En cours">
              En cours
            </option>
            <option value="Terminée">
              Terminée
            </option>
          </select>
        </div>
        <div>
          <label for="user">Attribution</label>
          <select name="user" id="user">
            <?php
            foreach ($users as $user) 
            {
            ?>
            <option value="<?= $user->ID; ?>" >
            <?= $user->display_name ?>
            </option>
            <?php
            }
            ?>
          </select>
        </div>
        <input type="submit" value="Ajouter">
      </form>
      <h2>Modifier une tâche</h2>
      <form id="put">
        <div>
          <label for="id">ID</label>
          <input type="number" name="id" id="id">
        </div>
        <div>
          <label for="title">Title</label>
          <input type="text" name="title" id="title">
        </div>
        <div>
          <label for="description_tache">Description</label>
          <input type="text" name="description_tache" id="description_tache">
        </div>
        <div>
          <label for="state_tache"></label>
          <select name="state_tache" id="state_tache">
            <option value="À faire">
              À faire
            </option>
            <option value="En cours">
              En cours
            </option>
            <option value="Terminée">
              Terminée
            </option>
          </select>
        </div>
        <div>
          <label for="user">Attribution</label>
          <select name="user" id="user">
            <?php
            foreach ($users as $user) 
            {
            ?>
            <option value="<?= $user->ID; ?>" >
              <?= $user->display_name ?>
            </option>
            <?php
            }
            ?>
          </select>
        </div>
        <input type="submit" value="Modifier">
      </form>
      <h2>
        Supprimer une tâche
      </h2>
      <form id="delete">
        <label for="id">ID</label>
        <input type="number" id="id">
        <input type="submit" value="Delete">
      </form>
      <h2>
        Liste des tâches
      </h2>
      <ul id="ul_put"></ul>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <?php require_once "js/script.php";

}