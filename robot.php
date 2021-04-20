<?php

/* ---------------------------------------------------Fonctions-----------------------------------------------------------*/

   // Fonction de traitement des données de format JSON issues d'une URL
   function url_response($url){

       $json_content = file_get_contents($url);

       $json_response = json_decode($json_content, true);

       return $json_response;

   }

/* ---------------------------------Construction de l'API des articles wikipedia à améliorer------------------------------*/


   //URL de base ou API MEDIAWIKI de base
   $url_base = "https://fr.wikipedia.org/w/api.php?action=parse&format=json&page=Projet:C%C3%B4te_d%27Ivoire/Articles_r%C3%A9cents/Archive&prop=links";

   $data = url_response($url_base);

   if (isset($data->{'parse'}->{'links'})) {
      
      foreach ($data->{'parse'}->{'links'} as $content_first) {
         
         // Page Wiki de la CIV225
         $page_wiki = $content_first->{'*'};

         // URL de traitement des modèles ou templates incomplète
         $url_first = "https://fr.wikipedia.org/w/api.php?action=parse&format=json&prop=templates&page=";

         // Incrémentation des différentes pages WIKI issues de l'Archive CIV225
         $url_second += $url_first.$page_wiki;

         $page_wiki_treatment = url_response($url_second);

         if (isset($page_wiki_treatment->{'parse'}->{'templates'})) {

            foreach ($page_wiki_treatment->{'parse'}->{'templates'} as $content_second) {
               
               $data_second = $content_second->{'*'};

               if (isset($data_second)) {
                  
                  $modele_template = array("Modèle:Sources secondaires",
                                           "Modèle:Sources",
                                           "Modèle:Méta bandeau d'avertissement");

                  if (in_array($data_second, $modele_template)) {
                     
                     // Page WIKI à améliorer
                     echo $page_wiki;
                  }
               }


            }
         
         }
  
      }
   }



?>