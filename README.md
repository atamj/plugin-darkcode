##    Documentation

Documentation PDF

URL API: <url site>/copie-trello/wp-json/darkcode/v1/tasks/

URL liste des utilisateurs: <url site>/copie-trello/wp-json/darkcode/v1/users/

Retourne un tableau JSON

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
        
Documentation simplifié en JSON: <url site>/copie-trello/wp-json/darkcode/v1/doc/

Pour utiliser les ressources de l'Api utilisez l'URL ci-dessus.

Pour récupérer toutes les tâches faire une GET sur l'URL

                axios({
                  method: 'get',
                  url: url
                })
                .then( (response)=> {
                  let data = response.data
                  console.log(data)
                });
              

Pour récupérer ajouter un tâche faire un POST sur l'URL et utilisant les clés suivantes :
* title (le titre de la tâche)
* description_tache (description de la tâche)
* state_tache (À faire, en cours, terminée)
* user (L'ID de l'utilisateur attribué à la tâche)

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
              

    Pour modifier une tâche faire un PUT sur l'URL en rajoutant l'ID de la tâche à modifier en utilisant les clés suivantes :
        title (le titre de la tâche)
        description_tache (description de la tâche)
        state_tache (À faire, en cours, terminée)
        user (L'ID de l'utilisateur attribué à la tâche)

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
              

    Pour supprimer une tâche faire un DELETE sur l'URL en rajoutant l'ID de la tâche à supprimer.

                axios.delete(url+id)
              


