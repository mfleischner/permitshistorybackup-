 /** Search the text on the FAQ page **/

$(function() {
    var mark = function() {
         // Read the keyword
         var keyword = $("input[name='keyword']").val();

         // Determine selected options
         /*var options = {};
         $("input[name='opt[]']").each(function() {
             options[$(this).val()] = $(this).is(":checked");
         });*/

         // Remove previous marked elements and mark
         // the new keyword inside the context
        var options = {
            "element": "mark",
            "className": "",
            "exclude": [],
            "separateWordSearch": true,
            "accuracy": "partially",
            "diacritics": true,
            /*"synonyms": {},
            "iframes": false,
            "iframesTimeout": 5000,
            "acrossElements": false,
            "caseSensitive": false,
            "ignoreJoiners": false,
            "ignorePunctuation": [],
            "wildcards": "disabled",*/
            /*"filter": function(textNode, foundTerm, totalCounter, counter){
                // textNode is the text node which contains the found term
                // foundTerm is the found search term
                // totalCounter is a counter indicating the total number of all marks
                //              at the time of the function call
                // counter is a counter indicating the number of marks for the found term
                return true; // must return either true or false
            },
            "noMatch": function(term){
                // term is the not found term
            },*/
            "done": function(counter){
                // counter is a counter indicating the total number of all marks
            },
            "debug": false,
            "log": window.console
        };
        $(".faq-txt").unmark({
             done: function() {
                 $(".faq-txt").mark(keyword, options);
             }
         });
     };

     $("input[name='keyword']").on("input", mark);
     //$("input[type='checkbox']").on("change", mark);

});