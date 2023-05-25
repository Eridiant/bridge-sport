document.addEventListener('DOMContentLoaded', () => {
    let link = document.querySelector('.link');
    let wrap = document.querySelector('.quiz-wrap');

    let sup = document.querySelector('#notifications sup');
    document.addEventListener('click', (e) => {
        if (e.target.closest('.aside-icon')) {
            document.querySelector('.aside').classList.add('show') ;
        }
        if (e.target.closest('.aside-close') || e.target.classList.contains('show')) {
            document.querySelector('.aside').classList.remove('show') ;
        }
        if (e.target.closest('#notifications')) {
            document.querySelector('.nav-popup').classList.toggle('show');
            if (sup.innerHTML !== '') {
                let data = {'post': 1};
                xhRequest(data, '/user/viewed')
                    .then(response => {
                        sup.innerHTML = '';
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
            return;
        }
        if (!e.target.closest('.nav-popup')) {
            document?.querySelector('.nav-popup')?.classList?.remove('show');
        }
    })

    wrap?.addEventListener('click', (e) => {
        let tg = e.target;
        if (tg.classList.contains('submit')) {
            let tgs = tg.closest('.submit').dataset;

            let form = document.querySelector('form input:checked');
            // console.log(tgs.quiz, tgs.id, form.dataset.answer);

            quizAjax(tgs.quiz, tgs.id, form.dataset.answer);
            
        }
        if (tg.classList.contains('link')) {
            quizAjax(wrap.dataset.id);
        }
    })

    // message
    let message = document.querySelector('.messages');
    if (message) {
        message.addEventListener('click', (e) => {
            e.preventDefault();
            let target = e.target;
            let wrapper = target.closest('.messages-wrapper');
            message.querySelectorAll('.messages-errors').forEach(el => {
                el.innerHTML = '';
            });
            // let answer = target.closest('.messages-answer');
            if (target.closest('.messages-answer')) {
                let edit = target.closest('a[data-edit]');
                if (edit !== null) {
                    let data = {
                        'post': message.dataset.post,
                        'id': target.closest('.messages-answer').dataset.messageId,
                        'parent': target.closest('.messages-answer').dataset.parentId
                    };

                    // console.log(target.querySelector('.messages-answer').dataset.messageId);
                    if (Number(edit.dataset.edit)) {
                        return;
                        xhRequest(data, '/post/edit-message')
                            .then(response => {
                                let er = '';
                                if (er = JSON.parse(response).data?.validate?.message) {
                                    // target.closest('.messages-form').querySelector('.messages-errors').innerHTML = er;
                                }
                                // console.log(JSON.parse(response));
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    } else {
                        xhRequest(data, '/post/delete-message')
                            .then(response => {
                                let reply = '';
                                if (reply = JSON.parse(response).data?.reply) {
                                    target.closest('.messages-inner').innerHTML = reply;
                                }
                                let msg = '';
                                if (msg = JSON.parse(response).data?.message) {
                                    target.closest('.messages-wrap').innerHTML = msg;
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                    return;
                }
                let form = wrapper.querySelector('.messages-form');
                let hide = document.querySelector('.messages-wrapper .messages-form:not(.hide)');
                if (hide) {
                    hide.classList.add('hide');
                    hide.querySelector('.messages-reply').innerHTML = '';
                }
                // console.log(wrapper.querySelector('.messages-reply'), target.closest('.messages-answer').dataset.user);
                wrapper.querySelector('.messages-reply').innerHTML = 'ответить ' + target.closest('.messages-answer').dataset.user + '\'у';
                form.classList.remove('hide');
                form.dataset.answerUser = target.closest('.messages-answer').dataset.userId;
                form.dataset.messageId = target?.closest('.messages-answer:not(.message)')?.dataset?.messageId;
                form.scrollIntoView({block: "nearest", behavior: "smooth"});
                wrapper.querySelector('.messages-textarea').focus();
                // form.dataset.messageId = message_id;
            }

            // let send = target.closest('.messages-btn'); 
            if (target.closest('.messages-btn')) {
                // console.log(message);
                let data = {
                    'post': message.dataset.post,
                    'message': target.closest('.messages-form').querySelector('.messages-textarea').innerHTML,
                    'answer': target.closest('.messages-form').dataset.answerUser,
                    'parent': wrapper?.querySelector('.messages-answer').dataset.parentId,
                    'answerId': target.closest('.messages-form').dataset.messageId
                };

                xhRequest(data, '/post/message')
                    .then(response => {
                        let er = '';
                        if (er = JSON.parse(response).data?.validate?.message) {
                            target.closest('.messages-form').querySelector('.messages-errors').innerHTML = er;
                        }
                        let reply = '';
                        if (reply = JSON.parse(response).data?.reply) {
                            let el = document.createElement("div");
                            el.className = "messages-inner";
                            el.innerHTML = reply;
                            wrapper.insertBefore(el, wrapper.querySelector('.messages-form'));
                            wrapper.querySelector('.messages-textarea').innerHTML = '';
                            wrapper.querySelector('.messages-reply').innerHTML = '';
                        }
                        let msg = '';
                        if (msg = JSON.parse(response).data?.message) {
                            let el = document.createElement("div");
                            el.className = "messages-wrapper";
                            el.innerHTML = msg;
                            message.insertBefore(el, message.querySelector('.messages-form.msg'));
                            message.querySelector('.messages-textarea.msg').innerHTML = '';
                        }
                        // console.log(JSON.parse(response));
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        })

        // newLines = str.split('\n').length-1;
    }

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
                // console.log('fff', results);
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

    ///////////////////////////

    let poll = document.querySelector('.poll');
    if (poll) {
        // poll.addEventListener('click', (e) => {
        //     let target = e.target;
        //     let lock = document.querySelector('.lock');
        //     if (lock) {
        //         target.closest('label').classList.add('click');
        //     }
        // })
        let submit = document.querySelector('#poll-submit');
        submit?.addEventListener('click', (e) => {
            e.preventDefault();
            let flag = true;
            let error = document.querySelectorAll('.fill-error');
            error.forEach(element => {
                element.classList.remove('fill-error');
            })

            let checkAnswer = document.querySelectorAll('.poll .poll-question');
            let checked = document.querySelectorAll('.poll input:checked');
            let data = new Object();
            data['poll'] = poll.dataset.id;
            console.log('data', data);
            checkAnswer.forEach(element => {
                let currentAnswers = element.querySelectorAll('input');
                let currentAnswersChecked = element.querySelectorAll('input:checked');
                let arr = [];
                currentAnswers.forEach(element => {
                    // console.log('qwerqw', element.value);
                    if (element.checked) {
                        arr.push(element.value);
                    }
                })
                data[element.closest('.poll-question').dataset.id] = arr;
                // console.log('length', currentAnswers.length);

                // fix count for input text and num
                if (currentAnswersChecked.length) return;

                flag = false;
                element.scrollIntoView({block: "center"});
                element.querySelector('.poll-answer').classList.add('fill-error');
            });
            // console.log('data', data);

            if (!flag) return;
            // checked.forEach(element => {
                // data.set("element.closest('.poll-question').dataset.id", element.value)
                // data[element.closest('.poll-question').dataset.id] = element.value;
                // data[element.value] = 1;
                // console.log('element', element, element.value, element.closest('.poll-question').dataset.id);
            // });

            xhRequest(data, '/poll/results')
                .then(response => {
                    let obj = JSON.parse(response);

                    obj.rslt.forEach(el => {
                        // console.log('el', el.type);
                        let question = document.querySelector(`.poll-question[data-id="${el.id}"]`);
                        // question.querySelector('.poll-answer').innerHTML = el.answers[0].description;
                        // question.querySelector('.poll-answer').classList.add('fill-success');
                        // console.log('question', question);
                        let comment = document.createElement("p");
                        comment.textContent = el.comment;
                        question.insertAdjacentElement("beforeend", comment);
                        if (el.type < 2) {
                            let sum = 0;
                            el.answers.forEach(answer => {
                                sum += answer.result.result_count + obj.show_only_user_result * answer.result.result_guest_count;
                            });

                            el.answers.forEach(answer => {
                                let answr = question.querySelector(`.poll-answer input[value="${answer.id}"]`).closest('label');
                                let pElement = document.createElement("p");
                                pElement.textContent = answer.result.text;

                                if (obj.show_result) {
                                    let fillerElement = document.createElement("div");
    
                                    fillerElement.classList.add(`answer-${answer.result.is_correct}`);
                                    // Вычисление процента ширины строки
                                    let percent = Math.round(((answer.result.result_count + obj.show_only_user_result * answer.result.result_guest_count) / sum) * 100);
                                    // Установка стилей для заполнителя
                                    fillerElement.style.width = percent + "%";
                                    answr.insertAdjacentElement("afterend", fillerElement);
                                }

                                answr.insertAdjacentElement("afterend", pElement);
                            });
                        }
                    });
                    document.querySelectorAll('.poll input').forEach(element => {
                        if (element.checked && element.closest('label')) {
                            element.closest('label').classList.add('checked');
                        }
                        element.remove();
                    });
                    document.querySelector('.poll .poll-question').scrollIntoView({block: "center"});
                    document.querySelector('.poll').classList.add('lock');
                    document.querySelector('.poll button').remove();
                })
                .catch(error => {
                    console.log(error);
                    console.error('error');
                });

        })
    
    }
})

function fetchRequest(data, cntr) {
    let promise = fetch(`/admin/${cntr}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    });
    return promise;
}

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