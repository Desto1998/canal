<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canal|Getel|Doc</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->

    <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.png">

    <!-- Custom fonts for this template-->
    <link href={{ asset('vendor/fontawesome-free/css/all.min.css') }} rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href={{ asset('css/sb-admin-2.min.css') }} rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href={{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }} rel="stylesheet">
    {{--Datatables css--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    {{--    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    {{--Datatables js--}}
    <script src="http://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        a {
            color: white;
        }

        @import url('https://fonts.googleapis.com/css?family=Abel');
        h1 {
            font-family: 'Abel', sans-serif;
            font-weight: 100;
            font-size: 40px;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        a {
            outline: 0 !important;
        }

        .magnific-img img {
            width: 100%;
            height: auto;
        }

        .mfp-bottom-bar, * {
            font-family: 'Abel', sans-serif;
        }

        .magnific-img {
            display: inline-block;
            width: 32.3%;
        }

        a.image-popup-vertical-fit {
            cursor: -webkit-zoom-in;
        }

        .mfp-with-zoom .mfp-container,
        .mfp-with-zoom.mfp-bg {
            opacity: 0;
            -webkit-backface-visibility: hidden;
            /* ideally, transition speed should match zoom duration */
            -webkit-transition: all 0.3s ease-out;
            -moz-transition: all 0.3s ease-out;
            -o-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        .mfp-with-zoom.mfp-ready .mfp-container {
            opacity: 1;
        }

        .mfp-with-zoom.mfp-ready.mfp-bg {
            opacity: 0.98;
        }

        .mfp-with-zoom.mfp-removing .mfp-container,
        .mfp-with-zoom.mfp-removing.mfp-bg {
            opacity: 0;
        }

        .mfp-arrow-left:before {
            border-right: none !important;
        }

        .mfp-arrow-right:before {
            border-left: none !important;
        }

        button.mfp-arrow, .mfp-counter {
            opacity: 0 !important;
            transition: opacity 200ms ease-in, opacity 2000ms ease-out;
        }

        .mfp-container:hover button.mfp-arrow, .mfp-container:hover .mfp-counter {
            opacity: 1 !important;
        }


        /* Magnific Popup CSS */
        .mfp-bg {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1042;
            overflow: hidden;
            position: fixed;
            background: #0b0b0b;
            opacity: 0.8;
        }

        .mfp-wrap {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1043;
            position: fixed;
            outline: none !important;
            -webkit-backface-visibility: hidden;
        }

        .mfp-container {
            text-align: center;
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            padding: 0 8px;
            box-sizing: border-box;
        }

        .mfp-container:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
        }

        .mfp-align-top .mfp-container:before {
            display: none;
        }

        .mfp-content {
            position: relative;
            display: inline-block;
            vertical-align: middle;
            margin: 0 auto;
            text-align: left;
            z-index: 1045;
        }

        .mfp-inline-holder .mfp-content,
        .mfp-ajax-holder .mfp-content {
            width: 100%;
            cursor: auto;
        }

        .mfp-ajax-cur {
            cursor: progress;
        }

        .mfp-zoom-out-cur, .mfp-zoom-out-cur .mfp-image-holder .mfp-close {
            cursor: -moz-zoom-out;
            cursor: -webkit-zoom-out;
            cursor: zoom-out;
        }

        .mfp-zoom {
            cursor: pointer;
            cursor: -webkit-zoom-in;
            cursor: -moz-zoom-in;
            cursor: zoom-in;
        }

        .mfp-auto-cursor .mfp-content {
            cursor: auto;
        }

        .mfp-close,
        .mfp-arrow,
        .mfp-preloader,
        .mfp-counter {
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        .mfp-loading.mfp-figure {
            display: none;
        }

        .mfp-hide {
            display: none !important;
        }

        .mfp-preloader {
            color: #CCC;
            position: absolute;
            top: 50%;
            width: auto;
            text-align: center;
            margin-top: -0.8em;
            left: 8px;
            right: 8px;
            z-index: 1044;
        }

        .mfp-preloader a {
            color: #CCC;
        }

        .mfp-preloader a:hover {
            color: #FFF;
        }

        .mfp-s-ready .mfp-preloader {
            display: none;
        }

        .mfp-s-error .mfp-content {
            display: none;
        }

        button.mfp-close,
        button.mfp-arrow {
            overflow: visible;
            cursor: pointer;
            background: transparent;
            border: 0;
            -webkit-appearance: none;
            display: block;
            outline: none;
            padding: 0;
            z-index: 1046;
            box-shadow: none;
            touch-action: manipulation;
        }

        button::-moz-focus-inner {
            padding: 0;
            border: 0;
        }

        .mfp-close {
            width: 44px;
            height: 44px;
            line-height: 44px;
            position: absolute;
            right: 0;
            top: 0;
            text-decoration: none;
            text-align: center;
            opacity: 0.65;
            padding: 0 0 18px 10px;
            color: #FFF;
            font-style: normal;
            font-size: 28px;
            font-family: Arial, Baskerville, monospace;
        }

        .mfp-close:hover,
        .mfp-close:focus {
            opacity: 1;
        }

        .mfp-close:active {
            top: 1px;
        }

        .mfp-close-btn-in .mfp-close {
            color: #333;
        }

        .mfp-image-holder .mfp-close,
        .mfp-iframe-holder .mfp-close {
            color: #FFF;
            right: -6px;
            text-align: right;
            padding-right: 6px;
            width: 100%;
        }

        .mfp-counter {
            position: absolute;
            top: 0;
            right: 0;
            color: #CCC;
            font-size: 12px;
            line-height: 18px;
            white-space: nowrap;
        }

        .mfp-arrow {
            position: absolute;
            opacity: 0.65;
            margin: 0;
            top: 50%;
            margin-top: -55px;
            padding: 0;
            width: 90px;
            height: 110px;
            -webkit-tap-highlight-color: transparent;
        }

        .mfp-arrow:active {
            margin-top: -54px;
        }

        .mfp-arrow:hover,
        .mfp-arrow:focus {
            opacity: 1;
        }

        .mfp-arrow:before,
        .mfp-arrow:after {
            content: '';
            display: block;
            width: 0;
            height: 0;
            position: absolute;
            left: 0;
            top: 0;
            margin-top: 35px;
            margin-left: 35px;
            border: medium inset transparent;
        }

        .mfp-arrow:after {
            border-top-width: 13px;
            border-bottom-width: 13px;
            top: 8px;
        }

        .mfp-arrow:before {
            border-top-width: 21px;
            border-bottom-width: 21px;
            opacity: 0.7;
        }

        .mfp-arrow-left {
            left: 0;
        }

        .mfp-arrow-left:after {
            border-right: 17px solid #FFF;
            margin-left: 31px;
        }

        .mfp-arrow-left:before {
            margin-left: 25px;
            border-right: 27px solid #3F3F3F;
        }

        .mfp-arrow-right {
            right: 0;
        }

        .mfp-arrow-right:after {
            border-left: 17px solid #FFF;
            margin-left: 39px;
        }

        .mfp-arrow-right:before {
            border-left: 27px solid #3F3F3F;
        }

        .mfp-iframe-holder {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .mfp-iframe-holder .mfp-content {
            line-height: 0;
            width: 100%;
            max-width: 900px;
        }

        .mfp-iframe-holder .mfp-close {
            top: -40px;
        }

        .mfp-iframe-scaler {
            width: 100%;
            height: 0;
            overflow: hidden;
            padding-top: 56.25%;
        }

        .mfp-iframe-scaler iframe {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
            background: #000;
        }

        /* Main image in popup */
        img.mfp-img {
            width: auto;
            max-width: 100%;
            height: auto;
            display: block;
            line-height: 0;
            box-sizing: border-box;
            padding: 40px 0 40px;
            margin: 0 auto;
        }

        /* The shadow behind the image */
        .mfp-figure {
            line-height: 0;
        }

        .mfp-figure:after {
            content: '';
            position: absolute;
            left: 0;
            top: 40px;
            bottom: 40px;
            display: block;
            right: 0;
            width: auto;
            height: auto;
            z-index: -1;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
            background: #444;
        }

        .mfp-figure small {
            color: #BDBDBD;
            display: block;
            font-size: 12px;
            line-height: 14px;
        }

        .mfp-figure figure {
            margin: 0;
        }

        .mfp-bottom-bar {
            margin-top: -36px;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            cursor: auto;
        }

        .mfp-title {
            text-align: left;
            line-height: 18px;
            color: #F3F3F3;
            word-wrap: break-word;
            padding-right: 36px;
        }

        .mfp-image-holder .mfp-content {
            max-width: 100%;
        }

        .mfp-gallery .mfp-image-holder .mfp-figure {
            cursor: pointer;
        }

        @media screen and (max-width: 800px) and (orientation: landscape), screen and (max-height: 300px) {
            /**
                 * Remove all paddings around the image on small screen
                 */
            .mfp-img-mobile .mfp-image-holder {
                padding-left: 0;
                padding-right: 0;
            }

            .mfp-img-mobile img.mfp-img {
                padding: 0;
            }

            .mfp-img-mobile .mfp-figure:after {
                top: 0;
                bottom: 0;
            }

            .mfp-img-mobile .mfp-figure small {
                display: inline;
                margin-left: 5px;
            }

            .mfp-img-mobile .mfp-bottom-bar {
                background: rgba(0, 0, 0, 0.6);
                bottom: 0;
                margin: 0;
                top: auto;
                padding: 3px 5px;
                position: fixed;
                box-sizing: border-box;
            }

            .mfp-img-mobile .mfp-bottom-bar:empty {
                padding: 0;
            }

            .mfp-img-mobile .mfp-counter {
                right: 5px;
                top: 3px;
            }

            .mfp-img-mobile .mfp-close {
                top: 0;
                right: 0;
                width: 35px;
                height: 35px;
                line-height: 35px;
                background: rgba(0, 0, 0, 0.6);
                position: fixed;
                text-align: center;
                padding: 0;
            }
        }

        @media all and (max-width: 900px) {
            .mfp-arrow {
                -webkit-transform: scale(0.75);
                transform: scale(0.75);
            }

            .mfp-arrow-left {
                -webkit-transform-origin: 0;
                transform-origin: 0;
            }

            .mfp-arrow-right {
                -webkit-transform-origin: 100%;
                transform-origin: 100%;
            }

            .mfp-container {
                padding-left: 6px;
                padding-right: 6px;
            }
        }

        body {
            letter-spacing: 1.8px;
        }

        .sidebar-menu {
            font-family: sans-serif;
        }

        .contenu {
            line-height: 25px;
            letter-spacing: 1.8px;
            font-family: slabo 27px;
        }
    </style>
</head>
<body id="body">
{{--<div class="container-fluid">--}}
<div class="col-md-12">
    <div class="row">
        {{--        Menu de la documentation--}}
        <div class="col-md-3 text-white pt-4 h-100 bg-primary sidebar-menu">
            <h4><a href="#body" class="text-white">Table de matières</a></h4>
            <p class="uppercase"><a>Abonnements</a></p>
            <div class="ml-6">
                <p><a href="#abonnement">Effectuer un abonnement</a></p>
                <p><a href="#abonnement-action">Action sur abonnement</a></p>
                <p><a href="#abonnement-sort">Trie sur les abonnement</a></p>
                <p><a href="#abonnement-others">Autre</a></p>
            </div>
            <p class="uppercase"><a>Réabonnements</a></p>
            <div class="ml-6">
                <p><a href="#reabonnement">Effectuer un reabonnement</a></p>
                <p><a href="#reabonnement-action"> Action dans reabonnement</a></p>
                <p><a href="#reabonnement-sort">Trie sur reabonnement</a></p>
                <p><a href="#reabonnement-others">Autre</a></p>
            </div>
            <p class="uppercase"><a>Upgrade</a></p>
            <div class="ml-6">
                <p><a href="#upgrade">Upgrade un reabonnement</a></p>
                <p><a href="#upgrade-actions">action sur upgrade</a></p>
                <p><a href="#upgrade-sort">Trie sur upgrade</a></p>
            </div>
            <p class="uppercase"><a>Materiels</a></p>
            <div class="ml-6">
{{--                <p><a>Ajouter materiel</a></p>--}}
                <p><a href="#materiel">Gerer les materiels</a></p>
            </div>
            <p class="uppercase"><a>Gérer les clients</a></p>
            <div class="ml-6">
                <p><a>Effectuer un abonnement</a></p>
            </div>
            <p class="uppercase"><a>Messages</a></p>
            <div class="ml-6">
                <p><a>Effectuer un abonnement</a></p>
            </div>
            <p class="uppercase"><a>CGA</a></p>
            <div class="ml-6">
                <p><a>Effectuer un abonnement</a></p>
            </div>
            <p class="uppercase"><a>Caisse</a></p>
            <div class="ml-6">
                <p><a>Effectuer un abonnement</a></p>
            </div>
            <p class="uppercase"><a>Rapport</a></p>
            <div class="ml-6">
                <p><a>Effectuer un abonnement</a></p>
            </div>
            <p class="uppercase"><a>Comptes</a></p>
            <div class="ml-6">
                <p><a>Effectuer un abonnement</a></p>
            </div>
        </div> <!-- fin menu -->
        <!-- Contrnu de la doc -->
        <div class="col-md-8 p-4 contenu">
            <!-- Menu abonnement -->
            <h4>ABONNEMENT</h4>
            <div class="abonnement col" id="abonnement">
                <h5 class="text-green-50">Abonner un client</h5>
                <div>
                    <div>
                        <div>
                            <img src="{{ asset('images/doc-images/formulaire-abo.png') }}">
                        </div>
                        <p class="alert-warning">
                            L'abonnement du client ici inclut qu'il a acheté son matériel a la boutique
                        </p>
                        Pour effectuer un abonnement il faut:
                        <ul>
                            <li>Se rendre dans le menu <strong>Abonnement</strong>;</li>
                            <li>Cliquer sur le bouton <strong>"+"</strong> qui se trouve devant nouvel abonnement;</li>
                            <li>Remplir le formulaire qui va s'afficher. NB les autres champs sont obligatiores
                                en dehors des champs <strong>Prenom et Adresse!</strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col abonnement-action" id="abonnement-action">
                    <h5>Action sur abonnement</h5>
                    <p class="alert-warning pl-2">
                        NB: La supprssion d'un abonnement n'est possible que dans les 24h après son enregitrement!
                    </p>
                    Pour le faire:
                    <div class="">
                        <div>
                            <ul>
                                <li>Se rendre dans le menu <strong>Abonnement</strong></li>
                                <li>Rechercher l'abonnement en question en utilisant le numéro du client son nom ou
                                    prénom voire le 4
                                    le numéro du décodeur ou d'abonné;
                                </li>
                                <li class="h4 p-3">Supprimer un abonnement</li>

                                <li>Cliquer sur le bouton rouge dans la colonne <strong>action</strong>;</li>
                                <li>Valider lea suppression en cliequant sur Ok dans la boite de dialogue qui va
                                    s'afficher.
                                </li>
                                <li class="h4 p-3">Upgrade un abonnement</li>
                                <li>Cliquer sur le bouton jaune dans la colonne action.</li>
                                <li class="h4 p-3">Upgrade un abonnement</li>
                                <li>Cliquer sur le bouton vert dans la colonne action de l'abonnement</li>
                            </ul>
                        </div>
                        <div>
                            <img src="{{ asset('images/doc-images/bouton-action-abo.png') }}">
                        </div>
                    </div>
                </div>
                <div class="col abonnement-sort" id="abonnement-sort">
                    <h5>Trie sur abonnement</h5>
                    Les trie au niveau des abonnements et des reabonnements
                    prènent en compte 4 paramètres:
                    <h4>Le statut </h4>
                    <p>
                        <strong>Tous les statuts</strong>: Pour lister les abonnements effectués par tous les
                        utilisateurs;
                        <br>
                        <strong>Reabonné par moi</strong>: Pour lister les abonnements effectués uniquement par
                        l'utilisateur
                        courant(vous);<br>
                        <strong>Reabonné par autre</strong>: Pour lister les abonnements effectués par les autres
                        utilisateurs en dehors
                        de vous;
                    </p>
                    <h4>La date</h4>
                    <p>
                        <strong>Date de création</strong> Afficher les résultats du trie dans l'ordre decroissant des
                        date de création du plus ressent au plus ancien
                        <br>
                        <strong>Date de Reabo</strong> Afficher les résultats du trie dans l'ordre croissant des
                        date de réabonnement
                        <br>
                        <strong>Date échéance</strong> Afficher les résultats du trie dans l'ordre croissant des
                        date d'échéance.
                        <br>
                    </p>
                    <h4>La date minimale </h4>
                    <p>
                        Date de début du trie sur la periode;
                    </p>
                    <h4>La date maximale</h4>
                    <p>
                        Date de fin du trie sur la periode;
                    </p>

                    <div>
                        <img src="{{ asset('images/doc-images/formulaire-trie-abo.png') }}">
                    </div>
                </div>
                <div class="col abonnement-others" id="abonnement-others">
                    <h4>Autre</h4>
                    <p>
                        Le bouton <strong>Abonnements jour</strong> permet à l'utilisateur courant de voir
                        tous les abonnements qu'il a effectué aujourd'hui;
                        <br>
                        Le bouton <strong>Tous mes abonnements</strong> permet à un utilisateur de voir tous les clients
                        qu'il a abonné;
                    </p>
                    <img src="{{ asset('images/doc-images/abo-user-botton.png') }}">
                </div>
                <!-- Section reabonnement -->
                <div class="reabonnement" id="reabonnement">
                    <div class="reabonnement-new" id="reabonnement-new">
                        <h4>REABONNEMENT</h4>
                        <div class="abonnement col" id="abonnement">
                            <h5 class="text-green-50">Reabonner un client</h5>
                            <div>
                                <div>
                                    <p class="alert-warning">
                                        Pour reabonner un client il y a deux possibilités!
                                    </p>
                                    <h6 class="text-green-400 underline">Cas 1: Le client n'existe pas dans le
                                        sytème</h6>
                                    <p>Dans ce cas il faut: </p>
                                    <ul>
                                        <li>Se rendre dans le menu <strong>Reabonnement</strong>;</li>
                                        <li>Cliquer sur le bouton <strong>"+"</strong> qui se trouve devant Réabonnement
                                            Nouveau;
                                        </li>
                                        <li>Remplir le formulaire qui va s'afficher. NB les autres champs sont
                                            obligatiores
                                            en dehors des champs <strong>Prenom et Adresse!</strong>
                                        </li>
                                        <li>Cliquer sur le bouton <strong>Enregistrer.</strong></li>
                                    </ul>
                                </div>
                                <div>
                                    <img src="{{ asset('images/doc-images/reabo-home.png') }}">
                                </div>
                            </div>
                            <div class="mt-5">
                                <div>
                                    <h6 class="text-green-400 underline">Cas 2: Le client 'existe dans le sytème</h6>
                                    <p>Dans ce cas il faut: </p>
                                    <ul>
                                        <li>Se rendre dans le menu <strong>Reabonnement</strong>;</li>
                                        <li>Dans la liste des clients qui s'affichent dans le tableau rechercher le
                                            client à
                                            reabonner;
                                        </li>
                                        <li>Dans la colonne action cliquer sur le bouton en jaune(+) pour reabonner le
                                            clien;
                                        </li>
                                        </li>
                                        <li>Une nouvelle page s'ouvre avec un formulaire contenant les informations du
                                            client
                                            conpleter le formulaire et cliquer sur ""Reabonner"";
                                        </li>
                                    </ul>
                                </div>

                                <div class="m-5">
                                    <img src="{{ asset('images/doc-images/reabo-existing-client.png') }}">
                                </div>
                                <h3>Formulaire de reabonnment d'un client existant</h3>
                                <div class="m-5">
                                    <img src="{{ asset('images/doc-images/reabo-existing-form.png') }}">
                                </div>
                            </div>

                        </div>
                        <div class="reabonnement-action" id="reabonnement-action">
                            <div class="d-flex">
                                <div class="col-md-6">
                                    <h5 class="text-green-50">Action sur les reabonnements</h5>
                                    <p class="p-3 alert-dark">
                                        Pour plus d'action sur les reabonnement il sufit de se rendre dans le menu
                                        <strong>Reabonnement</strong>
                                        et utiliser les boutons de navigation situé dans ce menu.<br>
                                        Ils sont:
                                    <h6>Reabonnements du jour</h6>
                                    <h6>Tous mes reabonnements</h6>
                                    <h6>Tous les reabonnements</h6>
                                    <h6>Reabonnements à crédit</h6>
                                    </p>
                                    <p>
                                        Les actions supplémentaires sur les reabonnements sont:<br>
                                        Supprimer un reabonnement <br>
                                        Imprimer la facture<br>
                                        Recouvrir le crédit pour les reabonnements à crédit<br>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ asset('images/doc-images/reabo-action-btn.png') }}">
                                </div>
                            </div>
                        </div>
                        <div class="reabonnement-sort" id="reabonnement-sort">
                            <h5>Effectuer les tries sur les reabonnements</h5>
                            <p>
                                Pour effectuer les tries sur les reabonnements il faut:
                                <br>
                                Se rendre dans le menu Reabonnement et puis cliquer sur le bouton
                                "Tous les reabonnement"
                            </p>
                            <p class="alert-secondary p-3">
                                Les tries dans les réabonnements se font de la même façon que dans les abonnements
                            </p>
                        </div>
                        <div class="reabonnement-others" id="reabonnement-others">
                            <h5>Autre</h5>
                            <p>Il s'agit des boutons de navigations situés dans le menu <strong>Reabonnement</strong></p>
                        </div>
                    </div>
                    <!-- Section upgrade -->
                    <div class="upgrade" id="upgrade">
                        <h3>Upgrade</h3>
                        <p class="alert-success p-3">
                            Pour consulter tous les UPGRADES  il faut se rendre dans le menu
                            <strong>Upgrade</strong> et cliquer sur le bouton <strong>Tous les upgrades</strong>
                        </p>
                        <div class="upgrade-new" id="upgrade-new">
                            <h5>Upgrade un reabonnement</h5>
                            <p>
                                Pour upgrade un reabonnement il faut:
                            </p>
                            <ul>
                                <li>Se rendre dans le menu <strong>Upgrade</strong>;</li>
                                <li>Recherche le reabonnement en question dans le tableau;</li>
                                <li>Cliquer sur le bouton jaune;</li>
                                <li>Un nouvelle page s'ouvre, chamger la formule et cliquer sur <strong>Upgrader</strong>
                                pour enregistrer.
                                </li>
                            </ul>
                            <div>
                                <img src="{{ asset('images/doc-images/upgrade-home.png') }}">
                            </div>
                        </div>
                        <div class="upgrade-actions mt-3" id="upgrade-actions">
                            <div class="d-flex">
                                <div class="col-md-6">
                                    <h5>Action sur upgrade</h5>
                                    <p>
                                        On ne peut que effectuer 2 type d'action sur les upgrades:
                                        <br>
                                        Supprimer l'upgrade<br>
                                        Recouvrir la dette pour les upgrades à crédit<br>
                                        Pour le faire:
                                        Il suffit d'accèder à liste des upgredes.
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ asset('images/doc-images/ugrade-action-btn.png') }}">
                                </div>
                            </div>

                        </div>
                        <div class="upgrade-sort mt-3" id="upgrade-sort">
                            <h5>Trie sur upgrade</h5>
                            <p class="alert-info p-3">
                                Le trie ici se fait de la même façon que dans abonnement à la seule différence que les résultats
                                s'affichent par ordre décroissant des de création. Du plus récent au plus ancien.
                            </p>
                        </div>
                    </div>
                    <!-- Materiel section -->
                    <div id="materiel" class="materirel">
                        <h3>Matériel</h3>
                        <div class="materiel-new" id="materiel-new">
                            <h5>Enregistrement d'un mateireil | Decodeur</h5>
                            <p class="alert-primary">
                                L'enregistrement d'un materiel ou d'un decodeur se fait dans le menu
                                <strong>Stock</strong>
                            </p>
                            <p>
                                <img src="{{ asset('images/doc-images/stock-home.png') }}" alt="Image materiel">
                            </p>
                            <p class="alert-danger p-3">
                                Attention: Ne pas supprimer un decodeur qui a déja été attribué à un client
                            </p>
                        </div>
                    </div>
                    <div class="container">

                        <h1>Simple Image Gallery with magnific-popup.js</h1>

                        <section class="img-gallery-magnific">
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit"
                                   href="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80"
                                   title="9.jpg">

                                    <img
                                        src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80"
                                        alt="9.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/900/?random"
                                   title="10.jpg">
                                    <img src="https://unsplash.it/900/?random" alt="10.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/902" title="3.jpg">
                                    <img src="https://unsplash.it/902/" alt="3.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/901" title="4.jpg">
                                    <img src="https://unsplash.it/901" alt="4.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/888/?random"
                                   title="1.jpg">
                                    <img src="https://unsplash.it/888/?random" alt="1.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/931/?random"
                                   title="2.jpg">
                                    <img src="https://unsplash.it/931/?random" alt="2.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/908/?random"
                                   title="5.jpg">
                                    <img src="https://unsplash.it/908/?random" alt="5.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/978/?random"
                                   title="6.jpg">
                                    <img src="https://unsplash.it/978/?random" alt="6.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/857/?random"
                                   title="7.jpg">
                                    <img src="https://unsplash.it/857/?random" alt="7.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/905/?random"
                                   title="8.jpg">
                                    <img src="https://unsplash.it/905/?random" alt="8.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/1230/?random"
                                   title="12.jpg">
                                    <img src="https://unsplash.it/1230/?random" alt="12.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/800/?random"
                                   title="13.jpg">
                                    <img src="https://unsplash.it/800/?random" alt="13.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/930/?random"
                                   title="14.jpg">
                                    <img src="https://unsplash.it/930/?random" alt="14.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/999/?random"
                                   title="15.jpg">
                                    <img src="https://unsplash.it/999/?random" alt="15.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="magnific-img">
                                <a class="image-popup-vertical-fit" href="https://unsplash.it/897/?random"
                                   title="16.jpg">
                                    <img src="https://unsplash.it/897/?random" alt="16.jpg"/>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                        </section>
                        <div class="clear"></div>

                    </div>
                </div>

            </div>
        </div>
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © GETEL SARL</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <div class="col-md-12 text-right">
        </div>
    </div>
    {{--</div>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.image-popup-vertical-fit').magnificPopup({
                type: 'image',
                mainClass: 'mfp-with-zoom',
                gallery: {
                    enabled: true
                },

                zoom: {
                    enabled: true,

                    duration: 300, // duration of the effect, in milliseconds
                    easing: 'ease-in-out', // CSS transition easing function

                    opener: function (openerElement) {

                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                }

            });

        });
    </script>
</body>
</html>

