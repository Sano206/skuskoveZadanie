var a = 0;


function hlava() {
    var latex = document.getElementById('latex' + a);
    var htmlElement = document.getElementById('frajer' + a);
    var MQ = MathQuill.getInterface(2); // for backcompat
    var config = {

        restrictMismatchedBrackets: true
    };
    var mathField = MQ.MathField(htmlElement, config);

    mathField.latex(latex.value); // Renders the given LaTeX in the MathQuill field
    console.log(latex.id);
    a++;
    hlava();

}

hlava();