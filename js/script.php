<script>
  (()=> {
           //Récupère le form POST
           const form_post = document.querySelector('#post')

           //Récupère le form PUT
           const ul_put = document.querySelector("#ul_put")

           let form_put = document.querySelector("#put")

           //Récupère le form DELETE
           const form_delete = document.querySelector("#delete")

           //Récupère l'url des requètes
           const url = form_post.action

           //Variable 
           let taches, list_taches="";
           //Évèneme,t à l'envoi du formulaire POST
           form_post.addEventListener('submit',(e)=> {
             e.preventDefault()
             //Déclaration des variable de la fonction
             let title_post, description_post, state_post, user_id_post;
             let id_put, title_put, description_put, state_put, user_id_put;

             title_post = document.querySelector("#post #title")
             description_post = document.querySelector("#post #description_tache")
             state_post = document.querySelector("#post #state_tache")
             user_id_post = document.querySelector("#post #user")

             //Requête ajax pour enregistré la tâche
             axios({
               method: 'post',
               url: url,
               data: {
                 title: title_post.value,
                 description_tache: description_post.value,
                 state_tache: state_post.value,
                 user: user_id_post.value
               }
             });
             get_tache()

             //message de succès
             alert("Ajout effectué")

            }); //Fin de la fonction POST

            //Requette ajax DELETE
            form_delete.addEventListener('submit', (e)=>{
              e.preventDefault()
              let id_delete = form_delete.querySelector("#id").value
              axios.delete(url+id_delete)
              get_tache()
              alert("tache"+id_delete+"supprimé")
            })


           //Récupère les tâches de la BD

           get_tache()
           function get_tache(){

             axios({
               method: 'get',
               url: url
             })
             .then( (response)=> {
               taches = response.data

               taches.map((tache)=> {
                 let id_get = tache.ID
                 let title_get = tache.title
                 let description_get = tache.description_tache
                 let state_get = tache.state_tache
                 let user_id_get = tache.user_id

                 list_taches += "<li>ID: "+id_get+" | Title: "+title_get+" | Description: "+description_get+" | State: "+state_get+" | User ID: "+user_id_get+"</li>"

               })
               ul_put.innerHTML = list_taches;
               list_taches ="";
            }); //Fin de la requette GET

           } //Fin fonction get_tache
           

           //Requette PUT
           form_put.addEventListener("submit", (e)=>{
            e.preventDefault()
            id_put = document.querySelector("#put #id")
            title_put = document.querySelector("#put #title")
            description_put = document.querySelector("#put #description_tache")
            state_put = document.querySelector("#put #state_tache")
            user_id_put = document.querySelector("#put #user")

            //Requête ajax pour modifier la tâche
            axios({
              method: 'put',
              url: url+id_put.value,
              data: {
                title: title_put.value,
                description_tache: description_put.value,
                state_tache: state_put.value,
                user: user_id_put.value
              }
            });
            alert("Modification de la tache "+id_put.value+" effectué")
            get_tache()
           })

         })();
</script>