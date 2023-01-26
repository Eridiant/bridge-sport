window.addEventListener('load', () => {

    if (document.querySelector('#post-frame')) {

        let frame = document.querySelector('#post-frame');
        // console.log(frame);

        let listenerMap = function lm() {
            function loadScript() {
                return new Promise(function(resolve, reject) {
                    // var script = document.createElement("script");
                    // script.onload = resolve;
                    // script.onerror = reject;
                    // script.src = 'https://maps.googleapis.com/maps/api/js?asdfasdfasdfasdfasdfasdfasdf&region=EN&language=en';
                    // script.type = 'text/javascript';
                    // document.body.parentNode.appendChild(script);

                    // let iframeDiv = document.createElement('iframe');
                    let iframeDiv = document.createElement('div');
                    let iframe = frame.value;
                    // iframeDiv.onload = resolve;
                    // iframeDiv.onerror = reject;
                    // iframeDiv.src = iframe;
                    iframeDiv.innerHTML = `<iframe src="${iframe}"></iframe>`;
                    // document.body.appendChild(iframeDiv);
                    // document.querySelector('.wrapper').classList.add('dn');
                    document.querySelector('#ifr').appendChild(iframeDiv);
                    setTimeout(() => {
                        // document.querySelector('.wrapper').classList.remove('dn');
                        // html2canvas(document.body).then(function(canvas) {
                        //     var my_screen = canvas;
                        //     // console.log(document.querySelector('#ifr'));
                        //     document.querySelector('#ifr').appendChild(my_screen);
                        // });

                        // let node = document.querySelector('body');
                        // domtoimage.toPng(node)
                        //     .then(function (dataUrl) {
                        //         var img = new Image();
                        //         img.src = dataUrl;
                        //         document.body.appendChild(img);
                        //     })
                        //     .catch(function (error) {
                        //         console.error('oops, something went wrong!', error);
                        //     });
                    }, 3000);
                });
            }

            loadScript().then(response => {
                // map.innerHTML = '';
                
                // frame.removeEventListener('blur', listenerMap, false);

                // let inner = document.querySelector('#ifr iframe');
                
                setTimeout(() => {
                    // document.querySelector('.wrapper').classList.remove('dn');
                    html2canvas(document.body).then(function(canvas) {
                        var my_screen = canvas;
                        // console.log(document.querySelector('#ifr'));
                        document.querySelector('#ifr').appendChild(my_screen);
                    });	
                }, 3000);
                // iframe2image(inner, function (err, img) {
                //     // If there is an error, log it
                //     if (err) { return console.error(err); }
                //     // Otherwise, add the image to the canvas
                //     // context.drawImage(img, 0, 0);
                //     document.querySelector('#ifr').drawImage(img, 0, 0);
                // });
            });
        }
        let bbo = function bb() {
            let iframe = frame.value;
            ajaxRequest('post/cont', {'url':iframe})
                .then (response => {
                    document.querySelector('#ifr').innerHTML = response;
                });
        }
        // document.querySelector('#ifr').
        // frame.addEventListener('blur', bbo, false);
        // document.querySelector('#ifr').contentDocument.addEventListener('click', (e) => {
        //     e.preventDefault();
        //     // console.log('e.target');
        //     let inner = document.querySelector('#ifr iframe');
        //     console.log(inner);
        // })
        
    }

    // for del
    if (document.querySelector('#map')) {
        let map = document.querySelector('#map');

        let listenerMap = function lm() {
            function loadScript() {
                return new Promise(function(resolve, reject) {
                    var script = document.createElement("script");
                    script.onload = resolve;
                    script.onerror = reject;
                    script.src = 'https://maps.googleapis.com/maps/api/js?key=asdhfkajshdkfahsd&region=EN&language=en';
                    script.type = 'text/javascript';
                    document.body.parentNode.appendChild(script);
                });
            }
            
            loadScript().then(function() {
                // map.innerHTML = '';
                map.removeEventListener('click', listenerMap, false);
                init();
                map.classList.add('map-active');

            });
        }
        
        map.addEventListener('click', listenerMap, false);
        // map.addEventListener('keydown', liMa, false);
    }
    // for del

    if (document.querySelector('.name')) {
        let name = document.querySelector('.name');
        let translit = document.querySelector('.slug');
        let slug = translit.value;
        let mem = transliteration(name.value);
        let current = '';

        name.addEventListener('input', (e) => {
            current = transliteration(name.value);
            slug = translit.value;
            if (slug == mem || slug == '') {
                translit.value = current;
                mem = current;
            }

        })
    }

    const migrate = document.querySelector('.migrate-index');
    const area = document.querySelector('.migrate-area');
    migrate?.addEventListener('click', (e) => {
    // if (document.querySelector('.migrate-index')) {
        e.preventDefault();
        if (e.target.closest('.btn')) {
            // console.log(e.target.id);
            callMigrate(e.target.id)
                .then(response => {
                    let newElement = document.createElement("p");
                    newElement.textContent = JSON.parse(response);
                    area.insertBefore(newElement, document.querySelector('.migrate-area p'));
                })
                .catch(error => console.error('error'));
        }
    })

    let users = document.querySelector('#users');
    if (users) {
        users.addEventListener('change',(e) => {
            // console.log(e.target.closest('.user').dataset.id);
            // console.log(e.target.value);
            // alert('changed');
            let data = {'user':e.target.closest('.user').dataset.id, 'role':e.target.value}
            ajaxRequest("user/role", data)
                .then(response => {
                    if (!response) {
                        alert('error');
                    }
                    // console.log(response);
                    // console.log(JSON.parse(response));
                })
                .catch(error => {
                    alert(error);
                    console.log(error);
                });
        });
    }

    const bidding = document.querySelector('#bidding');

    if (bidding) {
        const tbody = document.querySelector('#body');
        const box = document.querySelector('#box'); 
        const contentValues = document.querySelector('#bidding-values');
        const competition = document.querySelector('#competition');
        const intervention = document.querySelector('#intervention');
        const vulnerable = document.querySelector('#vulnerable');
        const fillout = document.querySelector('#fillout');
        let intrvSwitch = 0;
        let opponent = 0;
        let passCounter = 0;
        let firstEl = 0;
        let double = 0;
        let values;

        requestData(null);

        contentValues.addEventListener('click', (e) => {
            const t = e.target;
            
            if (t.closest('.del')) {
                let dl = confirm("удалить?");
                if (!dl) return;
                let el = t.parentElement;
                // console.log(t.parentElement);
                let data = {
                    'id':el.dataset.id,
                }
                ajaxRequest("bid/del", data)
                    .then(response => {
                        let answer = JSON.parse(response);
                        // console.log(answer);
                        if (!answer.success) return;
                        el.remove();
                        box.querySelector(`span[data-num="${el.dataset.num}"]`).classList.remove('exist');
                    })
                    .catch(error => {
                        alert(error);
                        console.log(error);
                    });
                return;
            }
            if (t.dataset.num) {
                values = t;
                addBidListener();
            }
        })

        function checkOpponentBid() {
            let lc = foundPreviosBid(document.querySelector("#body span:last-child"));
            if (!lc) {
                opponent = intrvSwitch;
            } else {
                opponent = passCounter % 2 === 0 ? !Number(lc.dataset.opponent) : Number(lc.dataset.opponent);
                // if (intrvSwitch) opponent = !opponent;
            }
            return opponent;
        }

        function requestData(count, parent = tbody.dataset.parent) {
            checkOpponentBid();
            // console.log('opponent=', opponent, ' passCounter=', passCounter, ' intrvSwitch=', intrvSwitch, ' foundPreviosBid_opponent=', lc?.dataset?.opponent);
            let data = {
                'system_id':bidding.dataset.system,
                'parent_id':parent,
                'pass_count':count,
                'opponent':opponent,
            }
            ajaxRequest("bid/fill", data)
                .then(response => {
                    let answer = JSON.parse(response);

                    let data = answer.data;
                    contentValues.innerHTML = '';
                    box.querySelectorAll('.exist').forEach(el => {
                        el.classList.remove('exist');
                        el.removeAttribute("data-pr");
                        el.removeAttribute("data-opponent");
                    })

                    data.forEach(el => {
                        // values = document.createElement("div");
                        // let desc = el.description ? el.description : '';

                        values = `<div data-num="${el.num}" data-bid="${el.bid}" data-id="${el.id}" data-opponent="${el.opponent}" class=""><span  class="excerpt" contenteditable="false">${el.excerpt}</span><details><summary tabindex="-1"></summary><span class="details" contenteditable="false">${el.description ?? ''}</span></details><span class="del">&#10008;</span></div>`
                        contentValues.innerHTML += values;
                        // contentValues.append(values);
                        // values.dataset.num = el.num;
                        // values.dataset.bid = el.bid;
                        // values.dataset.id = el.id;
                        // let span = document.createElement("span");
                        // span.innerHTML = el.excerpt;
                        // values.append(span);
                        // span = document.createElement("span");
                        // span.classList.add('del');
                        // span.innerHTML = "X";
                        // values.append(span);
                        let currentSpan = box.querySelector(`span[data-num="${el.num}"]`);
                        currentSpan.classList.add('exist');
                        currentSpan.dataset.pr = el.id;
                        currentSpan.dataset.opponent = el.opponent;
                    });
                    // values.dataset.id = answer.data.id;
                    // values.contentEditable = 'false';
                    // values.classList?.remove('added');
                    // values.removeEventListener('click', removeBidListener, false);
                })
                .catch(error => {
                    alert(error);
                    console.log(error);
                });
        }

        function addBidListener() {
            // console.log('blur');
            values.querySelector('.excerpt').contentEditable = 'true';
            values.querySelector('.details').contentEditable = 'true';
            values.querySelector('details').open = 'true'; // ????
            // values.querySelector('span').addEventListener('blur', removeBidListener, false);
        }

        document.addEventListener("click", (e) => {
            let target = e.target;

            if (target.closest('#bidding-values .added') || target.closest('#box') || !document.querySelector('.added')) return;

            removeBidListener();
        })

        document.addEventListener('keydown', (event) => {
            const KEYCODE_ESC = 27;
            if (event.keyCode == KEYCODE_ESC) {
                escChange();
            }
        })

        document.addEventListener('keypress', (event) => {
            // console.log('event.keyCode', event.keyCode);
            if ((event.keyCode == 10 || event.keyCode == 13) && event.shiftKey)  {
                event.preventDefault();
                removeBidListener();
                return;
            }

            if ((event.keyCode == 10 || event.keyCode == 13) && event.ctrlKey) {
                event.preventDefault();
                removeDoubleSpace();
            }
        })

        function escChange() {
            if (!values.dataset?.id) {
                document.querySelector(`#box span[data-num="${values.dataset.num}"]`).classList.remove('exist');
                values.remove();
                return;
            }
            let data = {
                'id':values.dataset?.id,
            }
            ajaxRequest("bid/id", data)
                .then(response => {
                    let answer = JSON.parse(response);
                    values.querySelector('.excerpt').contentEditable = 'false';
                    values.querySelector('.details').contentEditable = 'false';
                    values.classList?.remove('added');
                    values.querySelector('.excerpt').innerHTML = answer.data.excerpt;
                    values.querySelector('.details').innerHTML = answer.data.description ?? '';
                })
                .catch(error => {
                    alert(error);
                    console.log(error);
                });
        }

        function removeDoubleSpace() {
            values.querySelector('.excerpt').innerHTML = values.querySelector('.excerpt').innerHTML.replace(/\s+/g,' ').replace(/^\s+|\s+$/,'');
            values.querySelector('.details').innerHTML = values.querySelector('.details').innerHTML.replace(/\s+/g,' ').replace(/^\s+|\s+$/,'');
        }

        function removeBidListener() {
            checkOpponentBid();
            // console.log('opponent=', opponent, ' passCounter=', passCounter, ' intrvSwitch=', intrvSwitch, ' foundPreviosBid_opponent=', lc?.dataset?.opponent);

            let data = {
                'system_id':bidding.dataset.system,
                'bid_id':values.dataset?.id,
                'parent_id':tbody.dataset?.parent,
                'bid_num':values.dataset?.num,
                'pass_count':passCounter,
                'opponent':opponent,
                'excerpt':values.querySelector('.excerpt').innerHTML,
                'details':values.querySelector('.details').innerHTML,
            }
            ajaxRequest("bid/add", data)
                .then(response => {
                    let answer = JSON.parse(response);
                    values.dataset.id = answer.data.id;
                    values.querySelector('.excerpt').contentEditable = 'false';
                    values.querySelector('.details').contentEditable = 'false';
                    values.querySelector('.excerpt').innerHTML = answer.data.excerpt;
                    values.querySelector('.details').innerHTML = answer.data.description ?? '';
                    values.classList?.remove('added');
                    // values.querySelector('span').removeEventListener('click', removeBidListener, false);
                    let currentSpan = document.querySelector(`#box span[data-num="${values.dataset.num}"]`);
                    currentSpan.dataset.pr = answer.data.id;
                    currentSpan.dataset.opponent = checkOpponentBid();
                })
                .catch(error => {
                    alert(error);
                    console.log(error);
                });
        }

        tbody.addEventListener('click', (e) => {

            const t = e.target;

            // passCounter = t.dataset.count;

            let prev = t.closest('span').previousElementSibling;
            if (prev === null) firstEl = passCounter = 0;
            else if (prev.dataset.num) passCounter = 0;
            else passCounter = prev.dataset.count;
            // document.querySelector('.bidding-table h1').innerHTML = passCounter;

            let prNum = foundPreviosBid(t)?.dataset?.num;
            if (prNum == -1) document.querySelector('#dbl').classList.add('redbl');
            if (prNum == -2) {
                document.querySelector('#dbl').classList.add('redbl');
                double = 1;
            } else double = 0;

            // console.log(passCounter % 2 === 0, t.previousElementSibling !== null);
            if (passCounter % 2 === 0 && t.previousElementSibling !== null) {
                competition.checked = true;
            }

            if (!foundPreviosBid(t)) {
                intervention.readOnly = false;
                intervention.classList.remove('dn');
            }

            delete t.closest('span').dataset.num;
            delete t.closest('span').dataset.parent;
            delete t.closest('span').dataset.count;
            delete t.closest('span').dataset.opponent;

            dblRd(passCounter);
            hideBid(prNum);

            myNextAll();

            let prParent = foundPreviosBid(t)?.dataset?.parent ?? 0;
            tbody.dataset.parent = prParent;

            requestData(passCounter, foundPreviosBid(t)?.dataset?.parent ?? 0);

            function myNextAll() {
                while (t.closest('span') !== tbody.lastElementChild) {
                    tbody.lastElementChild.remove();
                }

                document.querySelector("#body span:last-child").innerHTML = "?";
            }
        });

        function foundPreviosBid(el) {

            while (!el?.previousElementSibling?.dataset?.num && el?.previousElementSibling !== null) {
                el = el?.previousElementSibling;
            }
            // console.log("previousElementSibling", el?.previousElementSibling);

            return el.previousElementSibling === null ? 0 : el.previousElementSibling;

            // return asdfa;
            return el.previousElementSibling.dataset.num;
        }

        function foundPreviosValue(el) {

            while (!el?.dataset?.num && el !== null) {
                el = el?.previousElementSibling;
            }

            return el === null ? 0 : 1;
        }

        function foundPrevios(el) {
            // contentValues
            while (!el?.previousElementSibling?.classList?.contains('exist') && el?.previousElementSibling !== null) {
                el = el?.previousElementSibling;
            }
            return el?.previousElementSibling?.dataset?.num;
        }

        function dblRd(psc) {
            // console.log(psc % 2 === 0);
            let dbl = document.querySelector('#dbl');
            if (psc % 2 === 0) {
                // console.log('add');
                if (!dbl.classList.contains('dbl') && !double) dbl.classList.add('dbl');
                return;
            }
            // console.log('remove');
            dbl.classList.remove('dbl');
        }

        function hideBid(num) {

            if (num < 0) return;

            let style = document.querySelector('style');

            let st = `
                .bidding-wrapper span:nth-child(-n+${num}) {
                    height: 0;
                    opacity: 0;
                    font-size: 0px;
                }
            `;

            style.innerHTML = st;

        }

        box.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            addBidValue(e);
        })

        function addBidValue(e) {
            const t = e.target;
            let currentNum = t.dataset.num;
            if (contentValues.querySelector(`div[data-num="${currentNum}"]`)) {
                values = contentValues.querySelector(`div[data-num="${currentNum}"]`);
            } else {
                values = document.createElement("div");
                values.dataset.num = currentNum;
                values.dataset.bid = t.dataset.bid;

                values.innerHTML = `<span class="excerpt" contenteditable="false"></span><details><summary></summary><span class="details" contenteditable="false"></span></details><span class="del">&#10008;</span>`;
            }

            t.classList.add('exist');
            values.classList.add('added');

            let prevNum = foundPrevios(t);
            if (prevNum) document.querySelector(`#bidding-values div[data-num="${prevNum}"]`).after(values);
            else contentValues.prepend(values);
            addBidListener();
            values.querySelector('span').focus();
        }

        bidding.addEventListener('click', (e) => {
            // e.preventDefault();
            const t = e.target;
            // console.log(document.querySelector('#fillout').checked);
            let currentNum = t.dataset.num;
            if (fillout.checked && t.closest('#box') && currentNum) {
                addBidValue(e);
                return;
            }

            if (t.closest('.bidding-form')) {
                if (t.closest('#intervention')) {
                    // if (false) return;
                    // console.log('requestData', values.dataset?.num, passCounter, 0);
                    if (intervention.checked) {
                        intrvSwitch = 1;
                        requestData(passCounter, 0);
                        return;
                    }
                    intrvSwitch = 0;
                    requestData(passCounter, 0);
                    return;
                }
                // if (t.closest('#competition')) {
                //     competitionSwitch(competition.checked);
                //     return;
                // }
            }

            if (t.closest('#box') && t.dataset.num && (t.closest('.exist') || !Number(t.dataset.num))) {
                let current = document.querySelector('#body');

                let lastBid = document.querySelector("#body span:last-child");

                createEl(t.dataset.bid, lastBid);

                if (Number(t.dataset.num)) firstEl = 1;

                if (!competition.checked && passCounter < 1 && foundPreviosValue(lastBid)) createEl("pass");

                createEl("?", 0, 1);

                dblRd(passCounter);

                tbody.dataset.parent = foundPreviosBid(document.querySelector("#body span:last-child"))?.dataset?.parent ?? 0;
                requestData(passCounter);
                if (!Number(t.dataset.num)) return;

                function createEl(content, el = 0, trs = 0) {

                    if ((passCounter > 2 && firstEl) || passCounter > 3) return;

                    if (t.closest('.bidding-wrapper')) hideBid(t.dataset.num);

                    lastBid = el || document.createElement("span");

                    lastBid.innerHTML = content;
                    if (content !== "pass" && content !== "?") {
                        intervention.readOnly = true;
                        intervention.classList.add('dn');
                        lastBid.dataset.num = t.dataset.num;
                        lastBid.dataset.parent = t.dataset.pr;
                        lastBid.dataset.opponent = t.dataset.opponent;
                    }

                    current.append(lastBid);
                    checkCompetition(content);
                }

                function checkCompetition(content) {

                    if (t.dataset.num < 1 ) {
                        if (t.dataset.num === 0) return passCounter++;

                        if (t.dataset.num == -1) document.querySelector('#dbl').classList.add('redbl');

                        if (t.dataset.num == -2) double = 1;
                    }

                    if (t.dataset.num > 1 || t.dataset.num == -2) {
                        document.querySelector('#dbl').classList.remove('redbl');
                        document.querySelector('#dbl').classList.remove('dbl');
                    }
                    if (t.dataset.num > 1) double = 0;

                    if (content === "pass") {
                        passCounter++;
                        lastBid.dataset.count = passCounter;
                        return ;
                    }

                    if (content === "?") return;
                    lastBid.dataset.count = passCounter;
                    return passCounter = 0;
                }

                // function addTr() {
                //     let tr = document.createElement("tr");
                //     tbody.append(tr);
                    // tr = document.createElement("tr");
                    // tbody.className = "current";
                //     current = document.querySelector('#body tr:last-child');
                // }
                // current.querySelectorAll('td').length;
                // console.log();
            }
            // if (t.closest('#body') ) {
                
            // }
        })

        // function competitionSwitch(swtch) {
        //     if (swtch) {
        //         // createEl()
        //         createEl("?", 0, 1);
        //         console.log('true', passCounter, foundPreviosBid(tbody.lastChild));
        //     } else {
        //         console.log('false', passCounter, foundPreviosBid(tbody.lastChild));
        //     }
        // }

        vulnerable?.addEventListener('click',(e) => {
            const thd = document.querySelectorAll('#thead th');
            const t = e.target;
            
            switch (t.id) {
                case "none":
                    thead([0,0,0,0]);
                    break;
                case "all":
                    thead([1,1,1,1]);
                    break;
                case "nvul":
                    thead([0,1,0,1]);
                    break;
                case "vul":
                    thead([1,0,1,0]);
                    break;
                default:
                    break;
            }

            function thead(arr) {
                // console.log(thd);
                arr.forEach(function(item, i, arr) {
                    item ? thd[i].classList.add('vul') : thd[i].classList.remove('vul');
                    // console.log(item, i);
                    // arr[i] ? item.classList.add('.vul') : item.classList.remove('.vul');
                });
            }

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

function ajaxRequest(cntr, rqst) {
    // console.log(wrap.dataset.id);
    return new Promise((succeed, fail) => {
        // console.log(wrap.dataset.id);
        let quizRequest = new XMLHttpRequest();
        quizRequest.open("POST", `/admin/${cntr}`, true);
        quizRequest.setRequestHeader('Content-Type', 'application/json');

        quizRequest.setRequestHeader('X-CSRF-Token', document.querySelector('meta[name="csrf-token"]').content);
        quizRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        quizRequest.onload = function() {
            if(quizRequest.readyState == XMLHttpRequest.DONE && quizRequest.status == 200) {
                succeed(quizRequest.responseText);
            } else if (quizRequest.status == 400) {
                // throw Error('Ошибка: ' + quizRequest.status);
                fail(new Error(`Request failed: ${quizRequest.status}`));
            } else {
                // throw Error('Ошибка, что-то пошло не так.');
                fail(new Error(`Request failed: ${quizRequest.status}`));
            }
        }
        quizRequest.onerror = function() {console.log(onerror)};

        // let data = {};
        // let data = { 'flat':i };

        // quizRequest.send('survey_id=2&parent_id=0');
        // quizRequest.send(JSON.stringify(data));
        quizRequest.send(JSON.stringify(rqst));
    })
}

function callMigrate(cntr) {
    return new Promise((succeed, fail) => {
        let quizRequest = new XMLHttpRequest();
        quizRequest.open("POST", `/admin/migrate/${cntr}`, true);
        quizRequest.setRequestHeader('Content-Type', 'application/json');

        quizRequest.setRequestHeader('X-CSRF-Token', document.querySelector('meta[name="csrf-token"]').content);
        quizRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        quizRequest.onload = function() {
            if(quizRequest.readyState == XMLHttpRequest.DONE && quizRequest.status == 200) {
                succeed(quizRequest.responseText);
            } else if (quizRequest.status == 400) {
                // throw Error('Ошибка: ' + quizRequest.status);
                fail(new Error(`Request failed: ${quizRequest.status}`));
            } else {
                // throw Error('Ошибка, что-то пошло не так.');
                fail(new Error(`Request failed: ${quizRequest.status}`));
            }
        }
        quizRequest.onerror = function() {console.log(onerror)};

        let data = {};

        // quizRequest.send(JSON.stringify(data));
        quizRequest.send();
    })
}

function transliteration(word){

	var converter = {
		'а': 'a',    'б': 'b',    'в': 'v',    'г': 'g',    'д': 'd',
		'е': 'e',    'ё': 'e',    'ж': 'zh',   'з': 'z',    'и': 'i',
		'й': 'y',    'к': 'k',    'л': 'l',    'м': 'm',    'н': 'n',
		'о': 'o',    'п': 'p',    'р': 'r',    'с': 's',    'т': 't',
		'у': 'u',    'ф': 'f',    'х': 'h',    'ц': 'c',    'ч': 'ch',
		'ш': 'sh',   'щ': 'sch',  'ь': '',     'ы': 'y',    'ъ': '',
		'э': 'eh',   'ю': 'yu',   'я': 'ya'
	};

	word = word.toLowerCase();

	var answer = '';

	for (var i = 0; i < word.length; ++i ) {

		if (converter[word[i]] == undefined){

			answer += word[i];

		} else {

			answer += converter[word[i]];

		}

	}

	answer = answer.replace(/[^-0-9a-z]/g, '-');

	answer = answer.replace(/[-]+/g, '-');

	answer = answer.replace(/^\-|-$/g, ''); 

	return answer;

}