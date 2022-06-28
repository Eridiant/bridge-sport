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
            console.log(e.target.id);
            callMigrate(e.target.id)
                .then(response => {
                    let newElement = document.createElement("p");
                    newElement.textContent = JSON.parse(response);
                    area.insertBefore(newElement, document.querySelector('.migrate-area p'));
                })
                .catch(error => console.error('error'));
        }
    })
})

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
    // console.log(wrap.dataset.id);
    return new Promise((succeed, fail) => {
        // console.log(wrap.dataset.id);
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