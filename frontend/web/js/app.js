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
})

function quizAjax(survey_id, parent_id = null, answer_id = null) {
    // console.log(wrap.dataset.id);
    let quizRequest = new XMLHttpRequest();
    quizRequest.open("POST", '/survey/quiz', true);
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