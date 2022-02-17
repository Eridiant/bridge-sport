document.addEventListener('DOMContentLoaded', () => {
    let quiz = document.querySelector('#quiz');

    quiz.addEventListener('click', (e) => {
        console.log(quiz.dataset.id);
        let quizRequest = new XMLHttpRequest();
        quizRequest.open("POST", '/survey/quiz', true);
        quizRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        quizRequest.setRequestHeader('X-CSRF-Token', yii.getCsrfToken());
        quizRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        quizRequest.onload = function() {
            if(quizRequest.readyState == XMLHttpRequest.DONE && quizRequest.status == 200) {
                rend(quizRequest.responseText);
            } else if (quizRequest.status == 400) {
                throw Error('Ошибка: ' + quizRequest.status);
            } else {
                throw Error('Ошибка, что-то пошло не так.');
            }
        }
        quizRequest.onerror = function() {console.log(onerror)};
        // let data = { survey_id: quiz.dataset.id };
        let data = { survey_id:'2', parent_id:'0'};
        // quizRequest.send('survey_id=2&parent_id=0');
        // quizRequest.send(JSON.stringify(data));
        // quizRequest.send(encodeURI(data));
        quizRequest.send(data);
    })
})

function rend(respond) {
    console.log(respond);
    
}