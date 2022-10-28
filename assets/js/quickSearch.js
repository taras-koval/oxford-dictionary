function getPossibleWordsIndex(wordBegin) {
    $.get("/quick-search?wordBegin=" + wordBegin, function (data) {
        if (data.status === 1) {
            $("#search").autocomplete("option", {
                source: data.matches
            });
        } else {
        }
    });
}

$('#search').on('input', function () {
    let possibleWord = $('#search').val();
    if (possibleWord.length > 2) {
        getPossibleWordsIndex(possibleWord);
    } else {
        $("#search").autocomplete({
            source: []
        });
    }
});

$('#player_new').html($("#player_raw").html());
$('#player_raw').html();

