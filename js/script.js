$("p1").ajax({
    url: 'teste.txt',
    content: document.body
}).done(function f(params) {
    $(this).done()
});