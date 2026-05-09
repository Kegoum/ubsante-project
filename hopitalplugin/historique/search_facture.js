$(document).ready(function() {
    var dated = $('#dated').val();
    var datef = $('#datef').val();
    var searchQuery='';
    listRecords(dated, datef, searchQuery);
    $('#multiSelectSearch').change(function() {
        $('#location').val($('#multiSelectSearch').val());
        searchQuery = $('#location').val();
        listRecords(dated, datef, searchQuery);
    });
});
function listRecords(dated, datef, searchQuery) {
    $.ajax({
        url: "hopitalpages/hopitalfacture/facture_search.php",
        method: "POST",
        dataType: "json",
        data: {query: searchQuery, dated: dated, datef: datef},
        success: function(response) {
            $('tbody').html(response.html);
        }
    });
}