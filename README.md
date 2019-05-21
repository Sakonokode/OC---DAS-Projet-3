# OC---DAS-Projet-3

Projet 3 de la formation Symfony d'OpenClassrooms.

## Consignes du projet

Jennifer Viala est l'organisatrice du Festival des Films de Plein Air. Elle ambitionne de sélectionner et projeter des films d'auteur en plein air du 5 au 8 août au parc Monceau à Paris.
Son association vient juste d'être créée et elle dispose d'un budget limité. Elle a besoin de communiquer en ligne sur son festival, d'annoncer les films projetés et de recueillir les réservations.

Voici ce qu'elle vous dit :

Mon association "Les Films de Plein Air" vient d'obtenir l'autorisation de projeter au parc Monceau cette année du 5 au 8 août chaque soir, de 18h à minuit. Je souhaite ainsi faire découvrir des films d'auteur au grand public.

J'ai besoin de communiquer sur le festival en amont et j'ai besoin pour cela d'une présence en ligne avec un site web. Sur ce site , pour lequel il faudra trouver une charte graphique, j'ai besoin notamment de présenter le festival, la liste des films et de communiquer régulièrement sur les dernières actualités du festival.

L'accès aux projections sera gratuit et ouvert à tous mais je souhaite que le public puisse se préinscrire pour estimer le nombre de personnes présentes chaque soir.

Je souhaite avoir une adresse professionnelle en .com ou en .org : je suis preneuse de conseils sur le meilleur choix pour l'adresse et je ne souhaite pas m'occuper de l'hébergement.

En tant que développeur, on vous demande de lister les fonctionnalités dont a besoin la cliente et de proposer une solution technique adaptée. Vous devez donc sélectionner la solution qui vous semble la plus à même de répondre à son besoin.

Vous devrez ensuite réaliser une première version de ce site correspondant à ses attentes.

## Installation
Prérequis : Vous avez besoin d'une version récente de node js, et Webpack  (installez le avec : `npm install -g webpack webpack-dev-server`)
    
    git clone git@github.com:Sakonokode/OC---DAS-Projet-3.git
    cd OC---DAS-Projet-3
    composer install
    npm install ou yarn install si vous utilisez yarn

Configurez la base de donnees en editant le fichier .env renseignez le nom de la base, l'utilisateur et le mot de passe.
Creez la base et charger les fixtures :

    bin/console doctrine:database:create --if-not-exists
    bin/console doctrine:schema:create
    bin/console doctrine:fixtures:load

Enfin, lancez yarn :

    yarn encore dev --watch
