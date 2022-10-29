$("#favorite-star").click(function () {
    let word = $(this).data('word');
    if (word) {
        $(this).hasClass('is-favorite') ? removeWord(word) : addWord(word);
    }
    $(this).toggleClass('is-favorite');
});

$(".btn-remove").click(function (e) {
    e.preventDefault();
    let link = $(this).parent();
    removeWord(link.data('word'));
    $(link).remove();
    if ($(".favorites").children().length === 0) {
        $("#export-button").remove();
    }
});

function removeWord(word) {
    $.ajax({
        type: 'DELETE',
        url: `/favorites/${word}`,
        success: function (result) {

        },
        error: function (result) {
            alert(result)
        }
    });
}

function addWord(word) {
    $.ajax({
        type: 'POST',
        url: "/favorites",
        data: {
            word: word
        },
        success: function (result) {

        },
        error: function (result) {
            alert(result)
        }
    });
}
