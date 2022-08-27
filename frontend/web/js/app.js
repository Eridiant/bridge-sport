document.addEventListener('DOMContentLoaded', () => {
    let link = document.querySelector('.link');
    let wrap = document.querySelector('.quiz-wrap');

    wrap?.addEventListener('click', (e) => {
        let tg = e.target;
        if (tg.classList.contains('submit')) {
            let tgs = tg.closest('.submit').dataset;

            let form = document.querySelector('form input:checked');
            console.log(tgs.quiz, tgs.id, form.dataset.answer);

            quizAjax(tgs.quiz, tgs.id, form.dataset.answer);
            
        }
        if (tg.classList.contains('link')) {
            quizAjax(wrap.dataset.id);
        }
    })

    let survey = document.querySelector('#survey');
    if (survey) {
        
        let surveyBy = document.querySelector('#survey span');
        let aski = document.querySelector('#aski');
        let results = [];

        aski.addEventListener('change', function(e){
            // console.log(e.target);
            survey.disabled = false;
            surveyBy.innerHTML = 'следующий вопрос';
            // this.form.querySelector('.btnSubmit').disabled = !this.checked
        })
    
        survey.addEventListener('click', (e) => {
            e.preventDefault();

            let selected = document.querySelector('form input:checked');

            // console.log(srv, nswr);
            // console.log(srv[1]);
            // console.log("selected", !selected);
            
            
            let ansr = '';

            if (selected) {
                let iady = selected.id;
                results.push(iady);

                iady = nswr[iady]?.id ? nswr[iady]?.id : prnt[selected.dataset.parent]?.id;

                slct(iady);
            } else {
                let ai = aski.dataset.parent ? prnt[aski.dataset.parent]?.id : -1;
                // console.log('ai', ai, aski.dataset.parent);
                slct(ai);
            }

            function slct(i = 0) {
                console.log('fff', results);
                i = i === -1 ? Object.keys(srv)[0] : i;
                if (srv[i]) {
                    srv[i].answers.forEach( el => {
                        ansr += `<div class="post-input"><input type="radio" name="radio" id="${el.id}" data-parent="${i}"><label for="${el.id}">${el.description}</label></div>`
                    })
                    aski.innerHTML = `<p>${srv[i].description}</p><div class="post-inputs">${ansr}</div>`;
                    if (srv[i].answers.length) {
                        survey.disabled = true;
                        surveyBy.innerHTML = 'выберите ответ';
                        aski.dataset.parent = '';
                    } else {
                        surveyBy.innerHTML = 'далее';
                        aski.dataset.parent = i;
                    }
                } else {
                    let data = {'survey': srv[Object.keys(srv)[0]]?.survey_id, 'results': results};
                    xhRequest(data, '/survey/quiz')
                        .then(response => {
                            let model = JSON.parse(response);
                            aski.innerHTML = model;
                            surveyBy.innerHTML = 'пройти тест заново';
                            aski.removeAttribute("data-parent");
                            results = [];
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            }
        });

    }

    
    // let data = {'survey_id': survey.dataset.id};
    // xhRequest(data, '/survey/quiz')
    //                 .then(response => {
    //                     let model = JSON.parse(response).model;
    //                     let status = JSON.parse(response).status;
    //                     // console.log(model, status);
    //                     document.querySelector('#floor-free').innerHTML = JSON.parse(response).flats_free + '/' + JSON.parse(response).flats;
    //                     fillData(model, status);
    //                 })
    //                 .catch(error => {
    //                     console.log(error);
    //                     console.error('error');
    //                 });

})


function xhRequest(data, url) {
    return new Promise((succeed, fail) => {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.setRequestHeader('X-CSRF-Token', document.querySelector('meta[name="csrf-token"]').content);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function () {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                // rend(JSON.parse(xhr.responseText));
                succeed(xhr.responseText);
            } else if (xhr.status == 400) {
                fail(new Error(`Request failed: ${xhr.status}`));
            } else {
                fail(new Error('Ошибка, что-то пошло не так.'));

            }
        }
        xhr.onerror = function () { console.log(onerror) };
        // console.log(data, url);
        // console.log(JSON.stringify(data));
        xhr.send(JSON.stringify(data));
    });
}

function quizAjax(survey_id, parent_id = null, answer_id = null) {
    // console.log(wrap.dataset.id);
    let quizRequest = new XMLHttpRequest();
    quizRequest.open("POST", '/survey/quizz', true);
    quizRequest.setRequestHeader('Content-Type', 'application/json');
    // quizRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    quizRequest.setRequestHeader('X-CSRF-Token', document.querySelector('meta[name="csrf-token"]').content);
    quizRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    quizRequest.onload = function() {
        if(quizRequest.readyState == XMLHttpRequest.DONE && quizRequest.status == 200) {
            // rend(JSON.parse(quizRequest.responseText));
            rend(quizRequest.responseText);

        } else if (quizRequest.status == 400) {
            throw Error('Ошибка: ' + quizRequest.status);
        } else {
            throw Error('Ошибка, что-то пошло не так.');
        }
    }
    quizRequest.onerror = function() {console.log(onerror)};
    // let data = { survey_id: quiz.dataset.id };
    let data = { 'survey_id':survey_id };
    if (parent_id !== null) {
        data.parent_id = parent_id;
    }
    if (answer_id !== null) {
        data.answer_id = answer_id;
    }

    // quizRequest.send('survey_id=2&parent_id=0');
    quizRequest.send(JSON.stringify(data));
    // quizRequest.send(encodeURI(data));
    // quizRequest.send(data);
    // quizRequest.send();
}

function rend(respond) {
    let wrap = document.querySelector('.quiz-wrap');
    wrap.innerHTML = respond;
    
}