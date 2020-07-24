import $ from 'jquery';
global.$ = $;
window.jQuery = $;
import '../css/app.css'
import 'jquery-datetimepicker'
import 'jquery-datetimepicker/build/jquery.datetimepicker.min.css'

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
$(".clickable-link").on("click", function (event) {
    //Lien
    if ($(event.target)[0].tagName == "A") {
        if (event.target.className != "btn btn-danger" && event.target.className != "fa fa-trash") {

            if (event.target.target == "_blank") {
                window.open(event.target.href);
                return false;
            }
            window.location = event.target.href;
        }
    }
    if ($(event.target)[0].tagName == "TD") {
        window.location = $(this).data("href");
    }

});
//Permet gérer les champs date des tâches
$.datetimepicker.setLocale('fr');
$("#tache_heureDebut").datetimepicker({
    step: 5,
    onShow: function (ct) {
        this.setOptions({
            maxDate: jQuery('#tache_heureFin').val() ? jQuery('#tache_heureFin').val() : false
        })
    },
    minTime: ''
});
$("#tache_heureFin").datetimepicker({
    step: 5,
    onShow: function (ct) {
        this.setOptions({
            minDate: jQuery('#tache_heureDebut').val() ? jQuery('#tache_heureDebut').val() : false
        })
    },
});
// Datatable des tâches
$(document).ready(function () {
    $('#table_tache').DataTable({
        language: {
            processing: "Traitement en cours...",
            search: "Rechercher une tâche :",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donnée disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });
});