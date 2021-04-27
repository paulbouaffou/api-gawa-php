<?php

/*
#############################################################################
#                                                                           #
#   @Auteur : Paul Bouaffou                                                 #
#                                                                           #
#   @Description : API de génération des articles wikipédia                 #
#   à améliorer liés à la Côte d'Ivoire                                     #
#                                                                           #
#   @Licence : Licence MIT                                                  #
#                                                                           #
#############################################################################
*/

/* ---------------------------Fonction(s)----------------------------------*/

   // Fonction de traitement des données de format JSON issues d'une URL
   function url_response($url){

       // Lecture des données au format JSON dans une chaîne
       $json_content = file_get_contents($url);

       // Décodage d'une chaîne JSON
       $json_response = json_decode($json_content, true);

       // Résultat
       return $json_response;

   }

/* --------------------------Construction de l'API des articles wikipedia à améliorer liés à la Côte d'Ivoire------------------------------*/


   // URL de base ou URL principale listant tous les articles wikipédia liés à la Côte d'Ivoire
   $url_base = "https://petscan.wmflabs.org/?language=fr&project=wikipedia&format=json&categories=Portail%3AC%C3%B4te+d%27Ivoire%2FArticles+li%C3%A9s%0D%0A&ns=0&depth=0&interface_language=fr&doit=";

   // Exécution de la fonction url_response()
   $data_first = url_response($url_base);

   // Détermine si la variable $data_first['*'] est déclarée et est différente de null
   if (isset($data_first['*'])) {
      
      foreach ($data_first['*'] as $content_first) {
         
         $data_second = $content_first['a']['*'];

         // Détermine si la variable $data_second est déclarée et est différente de null
         if (isset($data_second)) {
            
            foreach ($data_second as $content_second) {

               $page_wiki = $content_second['title'];

               // URL secondaire et incomplète pour l'obtention des modèles d'un article wikipédia
               $url_first = "https://fr.wikipedia.org/w/api.php?action=parse&format=json&prop=templates&page=";

               // URL secondaire et complète faisant passé en revue tous les articles wikipédia après encodage de ceux-ci
               $url_second = $url_first.urlencode($page_wiki);

               // Exécution de la fonction url_response()
               $page_wiki_treatment = url_response($url_second);

               // Détermine si la variable $page_wiki_treatment['parse']['templates'] est déclarée et est différente de null
               if (isset($page_wiki_treatment['parse']['templates'])) {
                  
                  foreach ($page_wiki_treatment['parse']['templates'] as $content_third) {
                     
                     $data_third = $content_third['*'];

                     // Détermine si la variable $data_third est déclarée et est différente de null
                     if (isset($data_third)) {
                        
                        // Modèle ou template wikipédia demandant l'amélioration d'un article
                        $modele_template = array("Modèle:Méta bandeau d'avertissement");

                        // Vérification de la présence du Modèle:Méta bandeau d'avertissement dans le groupe des modèles de l'article
                        if (in_array($data_third, $modele_template)) {
                           
                           // Article wikipédia à améliorer lié à la Côte d'Ivoire
                           echo $page_wiki."\n";
                        }
                     }
                  }
               }

            }
         }
      }
   }
   else {

      // Résultat en cas d'erreur
      echo "Le programme est en maintenance et veuillez nous excuser pour le désagrément causé !";
   }



      