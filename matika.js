var a = 0;

function aaa (){

    var mathFieldSpan = document.getElementById('math-field' + a);
    var otazka = document.getElementById('daco' + a);
    var latexSpan = document.getElementById('latex' + a);
    var bu = document.getElementsByClassName('somarina')[a];
// var mama = document.getElementById('mama');
    console.log(a);

    var MQ = MathQuill.getInterface(2); // for backcompat
    var mathField = MQ.MathField(mathFieldSpan, {
        spaceBehavesLikeTab: true, // configurable
        handlers: {
            edit: function() { // useful event handlers
                latexSpan.textContent = mathField.latex(); // simple API
                bu.value = mathField.latex();
                // mama.innerHTML = mathField.latex();
                //latexSpan = document.getElementById('latex').id = 'latex' + i;

            }
        }
    });

    var daco = MQ.MathField(otazka, {
        spaceBehavesLikeTab: true, // configurable
        handlers: {
            edit: function() { // useful event handlers
                latexSpan.textContent = daco.textContent; // simple API

            }
        }
    });
    a++;

    aaa();
}

aaa();
// //pole na vpisovanie
// var mathFieldSpan = document.getElementsByClassName('mathPole');
// //otazka
// var otazka = document.getElementsByClassName('otazka');
// //latex
// var latexSpan = document.getElementsByClassName('latex');
// //input
// var bu = document.getElementsByClassName('somarina');
// var i = 0;
// var j = 0;
//
// for (i = 0; i < mathFieldSpan.length; j++) {
//     var MQ = MathQuill.getInterface(2); // for backcompat
//     var current1 = latexSpan[i];
//     var current2 = bu[i];
//     var ha = MQ.MathField(mathFieldSpan[i], {
//         spaceBehavesLikeTab: true, // configurable
//         handlers: {
//             edit: function() { // useful event handlers
//                 current1.textContent = ha.latex(); // simple API
//                 current2.value = mathField.latex();
//                 // mama.innerHTML = mathField.latex();
//                 //latexSpan = document.getElementById('latex').id = 'latex' + i;
//             }
//         }
//     });
// }
//
// for (j = 0; i < otazka.length; j++) {
//     var MQ = MathQuill.getInterface(2); // for backcompat
//     var current3 = latexSpan[j];
//     var he = MQ.MathField(otazka[j], {
//         spaceBehavesLikeTab: true, // configurable
//         handlers: {
//             edit: function() { // useful event handlers
//                 current3.textContent = he.textContent; // simple API
//             }
//         }
//     });
// }
