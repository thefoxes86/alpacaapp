import * as axios from 'axios';

const BASE_URL = 'http://www.registroitalianoalpaca.it';

function upload(formData) {
    const url = `${BASE_URL}/grimmadmin/uploadAlpacaFoto`;
    

    return axios.post(url, formData)
        // get data
        .then(function (response) {
        	//x => x.data;
        	console.log(response);
        })
        // add url field
}

export { upload }