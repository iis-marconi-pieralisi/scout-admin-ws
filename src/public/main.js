/**
 * main.js
 * Helpers condivisi per account.js e iscrizione.js.
 */

function getById(id) {
    return document.getElementById(id);
}

function getValue(id) {
    const field = getById(id);
    return field ? field.value : '';
}

function setValue(id, value) {
    const field = getById(id);
    if (field) field.value = value;
}

function getChecked(id) {
    const field = getById(id);
    return field ? field.checked : false;
}

function setChecked(id, value) {
    const field = getById(id);
    if (field) field.checked = Boolean(value);
}

function resetForm(id) {
    const form = getById(id);
    if (form && typeof form.reset === 'function') {
        form.reset();
    }
}

function showResponse(message, isError = false) {
    const output = getById('apiResponse');
    if (!output) return;

    output.textContent = typeof message === 'string' ? message : JSON.stringify(message, null, 2);
    output.classList.toggle('has-text-danger', isError);
    output.classList.toggle('has-text-success', !isError);
}

function handleFetchError(error) {
    showResponse({ error: error.message || 'Errore di rete' }, true);
}

async function apiRequest(method, url, body = null) {
    const options = {
        method,
        headers: {
            'Content-Type': 'application/json',
        },
    };
    if (body !== null) {
        options.body = JSON.stringify(body);
    }

    const response = await fetch(url, options);
    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.error || `Errore ${response.status}`);
    }

    return data;
}

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function escapeAttr(value) {
    return String(value).replace(/'/g, "\\'").replace(/\"/g, '\\"');
}
