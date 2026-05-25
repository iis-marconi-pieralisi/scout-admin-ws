const apiBaseIter = '/api/iter';
const apiBaseBranca = '/api/branca';

function getInputValue(id) {
    const el = document.getElementById(id);
    return el ? el.value.trim() : '';
}

function setResponse(message, data, status = 200) {
    const responseBox = document.getElementById('response');
    if (!responseBox) return;
    responseBox.textContent = JSON.stringify({ status, message, data }, null, 2);
}

function setResultList(items) {
    const list = document.getElementById('result-list');
    if (!list) return;

    if (!Array.isArray(items)) {
        list.innerHTML = '<pre>Nessun dato disponibile.</pre>';
        return;
    }

    if (items.length === 0) {
        list.innerHTML = '<pre>Risposta vuota: non ci sono elementi.</pre>';
        return;
    }

    const headers = Object.keys(items[0]);
    const table = document.createElement('table');
    table.className = 'result-table';

    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    headers.forEach(header => {
        const th = document.createElement('th');
        th.textContent = header;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    items.forEach(item => {
        const row = document.createElement('tr');
        headers.forEach(header => {
            const td = document.createElement('td');
            td.textContent = item[header] ?? '';
            row.appendChild(td);
        });
        tbody.appendChild(row);
    });
    table.appendChild(tbody);

    list.innerHTML = '';
    list.appendChild(table);
}

async function fetchJSON(url, options = {}) {
    const headers = {
        'Content-Type': 'application/json',
        ...options.headers,
    };

    const response = await fetch(url, { ...options, headers });
    const text = await response.text();
    let data;
    try {
        data = text ? JSON.parse(text) : null;
    } catch (e) {
        data = text;
    }

    if (!response.ok) {
        throw { status: response.status, data };
    }

    return data;
}

function validateFields(required, payload) {
    for (const field of required) {
        if (!payload[field] || payload[field].toString().trim() === '') {
            setResponse(`Campo richiesto mancante: ${field}`, null, 400);
            return false;
        }
    }
    return true;
}

function getIterFields() {
    return {
        id_iter: getInputValue('id_iter') || null,
        nome: getInputValue('nome') || null,
        descrizione: getInputValue('descrizione') || null,
        id_branca: getInputValue('id_branca') || null,
    };
}

function getBrancaFields() {
    return {
        id_branca: getInputValue('id_branca') || null,
        nome_branca: getInputValue('nome_branca') || null,
        min_eta: getInputValue('min_eta') || null,
        max_eta: getInputValue('max_eta') || null,
    };
}

async function getIter() {
    try {
        const data = await fetchJSON(apiBaseIter, { method: 'GET' });
        setResponse('GET Iter eseguito con successo', data, 200);
        setResultList(data);
    } catch (error) {
        setResponse('GET Iter fallito', error.data || error, error.status || 500);
    }
}

async function createIter() {
    const payload = getIterFields();
    if (!validateFields(['nome', 'id_branca'], payload)) return;

    try {
        const data = await fetchJSON(apiBaseIter, {
            method: 'POST',
            body: JSON.stringify({
                nome: payload.nome,
                descrizione: payload.descrizione || null,
                id_branca: Number(payload.id_branca)
            })
        });
        setResponse('POST Iter eseguito con successo', data, 201);
        getIter();
    } catch (error) {
        setResponse('POST Iter fallito', error.data || error, error.status || 500);
    }
}

async function updateIter() {
    const payload = getIterFields();
    if (!validateFields(['id_iter', 'nome', 'id_branca'], payload)) return;

    try {
        const data = await fetchJSON(apiBaseIter, {
            method: 'PUT',
            body: JSON.stringify({
                id_iter: Number(payload.id_iter),
                nome: payload.nome,
                descrizione: payload.descrizione || null,
                id_branca: Number(payload.id_branca)
            })
        });
        setResponse('PUT Iter eseguito con successo', data, 200);
        getIter();
    } catch (error) {
        setResponse('PUT Iter fallito', error.data || error, error.status || 500);
    }
}

async function deleteIter() {
    const payload = getIterFields();
    if (!validateFields(['id_iter'], payload)) return;

    try {
        const data = await fetchJSON(apiBaseIter, {
            method: 'DELETE',
            body: JSON.stringify({ id_iter: Number(payload.id_iter) })
        });
        setResponse('DELETE Iter eseguito con successo', data, 200);
        getIter();
    } catch (error) {
        setResponse('DELETE Iter fallito', error.data || error, error.status || 500);
    }
}

async function getBranca() {
    try {
        const data = await fetchJSON(apiBaseBranca, { method: 'GET' });
        setResponse('GET Branca eseguito con successo', data, 200);
        setResultList(data);
    } catch (error) {
        setResponse('GET Branca fallito', error.data || error, error.status || 500);
    }
}

async function createBranca() {
    const payload = getBrancaFields();
    if (!validateFields(['nome_branca', 'min_eta', 'max_eta'], payload)) return;

    try {
        const data = await fetchJSON(apiBaseBranca, {
            method: 'POST',
            body: JSON.stringify({
                nome_branca: payload.nome_branca,
                min_eta: Number(payload.min_eta),
                max_eta: Number(payload.max_eta)
            })
        });
        setResponse('POST Branca eseguito con successo', data, 201);
        getBranca();
    } catch (error) {
        setResponse('POST Branca fallito', error.data || error, error.status || 500);
    }
}

async function updateBranca() {
    const payload = getBrancaFields();
    if (!validateFields(['id_branca', 'nome_branca', 'min_eta', 'max_eta'], payload)) return;

    try {
        const data = await fetchJSON(apiBaseBranca, {
            method: 'PUT',
            body: JSON.stringify({
                id_branca: Number(payload.id_branca),
                nome_branca: payload.nome_branca,
                min_eta: Number(payload.min_eta),
                max_eta: Number(payload.max_eta)
            })
        });
        setResponse('PUT Branca eseguito con successo', data, 200);
        getBranca();
    } catch (error) {
        setResponse('PUT Branca fallito', error.data || error, error.status || 500);
    }
}

async function deleteBranca() {
    const payload = getBrancaFields();
    if (!validateFields(['id_branca'], payload)) return;

    try {
        const data = await fetchJSON(apiBaseBranca, {
            method: 'DELETE',
            body: JSON.stringify({ id_branca: Number(payload.id_branca) })
        });
        setResponse('DELETE Branca eseguito con successo', data, 200);
        getBranca();
    } catch (error) {
        setResponse('DELETE Branca fallito', error.data || error, error.status || 500);
    }
}

function clearIterFields() {
    if (document.getElementById('id_iter')) document.getElementById('id_iter').value = '';
    if (document.getElementById('nome')) document.getElementById('nome').value = '';
    if (document.getElementById('descrizione')) document.getElementById('descrizione').value = '';
    if (document.getElementById('id_branca')) document.getElementById('id_branca').value = '';
    setResponse('Campi resettati.', null, 200);
}

function clearBrancaFields() {
    if (document.getElementById('id_branca')) document.getElementById('id_branca').value = '';
    if (document.getElementById('nome_branca')) document.getElementById('nome_branca').value = '';
    if (document.getElementById('min_eta')) document.getElementById('min_eta').value = '';
    if (document.getElementById('max_eta')) document.getElementById('max_eta').value = '';
    setResponse('Campi resettati.', null, 200);
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('[onclick="getBranca()"]')) {
        getBranca();
    } else if (document.querySelector('[onclick="getIter()"]')) {
        getIter();
    }
});
