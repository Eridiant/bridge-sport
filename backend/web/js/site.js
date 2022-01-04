window.addEventListener('load', () => {

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
    
})

function transliteration(word){

	var converter = {
		'а': 'a',    'б': 'b',    'в': 'v',    'г': 'g',    'д': 'd',
		'е': 'e',    'ё': 'e',    'ж': 'zh',   'з': 'z',    'и': 'i',
		'й': 'y',    'к': 'k',    'л': 'l',    'м': 'm',    'н': 'n',
		'о': 'o',    'п': 'p',    'р': 'r',    'с': 's',    'т': 't',
		'у': 'u',    'ф': 'f',    'х': 'h',    'ц': 'c',    'ч': 'ch',
		'ш': 'sh',   'щ': 'sch',  'ь': '',     'ы': 'y',    'ъ': '',
		'э': 'e',    'ю': 'yu',   'я': 'ya'
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