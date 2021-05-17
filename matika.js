var mathFieldSpan = document.getElementById('math-field');
//var otazka = document.getElementById('daco');
var latexSpan = document.getElementById('latex');
var bu = document.getElementsByClassName('somarina')[0];
var mama = document.getElementById('mama');

var MQ = MathQuill.getInterface(2); // for backcompat
var mathField = MQ.MathField(mathFieldSpan, {
    spaceBehavesLikeTab: true, // configurable
    handlers: {
        edit: function() { // useful event handlers
            latexSpan.textContent = mathField.latex(); // simple API
            bu.value = mathField.latex();
            mama.innerHTML = mathField.latex();
        }
    }
});

/*var daco = MQ.MathField(otazka, {
    spaceBehavesLikeTab: true, // configurable
    handlers: {
        edit: function() { // useful event handlers
            latexSpan.textContent = daco.textContent; // simple API

        }
    }
});*/

function vypis() {
    return latexSpan.value;
}
