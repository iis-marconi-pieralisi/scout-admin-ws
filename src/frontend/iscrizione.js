const API_ISCRIZIONE = '/api/iscrizione';
let iscrizioneCache = [];
let iscrizioneFormMode = 'create';
let iscrizioneEditingRowKey = null;

function setIscrizioneInlineStatus(message = '', type = 'info') {
    const statusEl = getById('iscrizioneInlineStatus');
    if (!statusEl) return;
    statusEl.textContent = message;
    let className = 'help';
    if (message) {
        className += type === 'error' ? ' has-text-danger' : type === 'warning' ? ' has-text-warning' : ' has-text-info';
    }
    statusEl.className = className;
}

function renderIscrizioni(items) {
    const tableBody = getById('iscrizioneTableBody');
    if (!tableBody) return;

    iscrizioneCache = Array.isArray(items) ? items : [];

    if (!Array.isArray(items) || items.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7">Nessuna iscrizione trovata.</td></tr>';
        return;
    }

    tableBody.innerHTML = items.map(item => {
        return `
            <tr data-iscrizione-anno="${escapeAttr(item.anno_associativo)}" data-iscrizione-id-persona="${escapeAttr(item.id_persona)}">
                <td>${escapeHtml(item.anno_associativo)}</td>
                <td>${escapeHtml(item.approvazione_capo)}</td>
                <td>${escapeHtml(item.id_persona)}</td>
                <td>${escapeHtml(item.id_pagamento)}</td>
                <td>${escapeHtml(item.id_unita)}</td>
                <td>${escapeHtml(item.id_iter)}</td>
                <td>
                    <button class="button is-small is-info" type="button" onclick="editIscrizioneRow('${escapeAttr(item.anno_associativo)}', '${escapeAttr(item.id_persona)}')">Modifica</button>
                    <button class="button is-small is-danger ml-2" type="button" onclick="deleteIscrizioneRow('${escapeAttr(item.anno_associativo)}', '${escapeAttr(item.id_persona)}')">Elimina</button>
                </td>
            </tr>
        `;
    }).join('');
}

function setIscrizioneFormMode(mode) {
    iscrizioneFormMode = mode === 'edit' ? 'edit' : 'create';
    const title = getById('iscrizioneFormTitle');
    const submitButton = getById('iscrizioneSubmitButton');

    if (title) {
        title.textContent = iscrizioneFormMode === 'edit' ? 'Modifica iscrizione' : 'Crea iscrizione';
    }
    if (submitButton) {
        submitButton.textContent = iscrizioneFormMode === 'edit' ? 'Modifica' : 'Crea';
        submitButton.className = iscrizioneFormMode === 'edit' ? 'button is-info' : 'button is-primary';
    }
}

function findIscrizioneRow(anno, idPersona) {
    const rows = document.querySelectorAll('#iscrizioneTableBody tr');
    return Array.from(rows).find(row => row.dataset.iscrizioneAnno === String(anno) && row.dataset.iscrizioneIdPersona === String(idPersona));
}

function editIscrizioneRow(anno, idPersona) {
    const iscrizione = iscrizioneCache.find(item => String(item.anno_associativo) === String(anno) && String(item.id_persona) === String(idPersona));
    if (!iscrizione) return;

    const row = findIscrizioneRow(anno, idPersona);
    if (!row) return;

    iscrizioneEditingRowKey = `${anno}-${idPersona}`;
    setIscrizioneCreateFormEnabled(false);
    setIscrizioneInlineStatus('Modifica in corso nella tabella. Salva o annulla per tornare al form di creazione.', 'warning');

    const approvazioneChecked = iscrizione.approvazione_capo === '1' || iscrizione.approvazione_capo === 'true' || iscrizione.approvazione_capo === true;

    row.innerHTML = `
        <td>${escapeHtml(iscrizione.anno_associativo)}</td>
        <td class="has-text-centered"><input name="editIscrizioneApprovazione" type="checkbox" class="checkbox" ${approvazioneChecked ? 'checked' : ''}></td>
        <td>${escapeHtml(iscrizione.id_persona)}</td>
        <td><input name="editIscrizioneIdPagamento" class="input" type="number" value="${escapeAttr(iscrizione.id_pagamento)}"></td>
        <td><input name="editIscrizioneIdUnita" class="input" type="number" value="${escapeAttr(iscrizione.id_unita)}"></td>
        <td><input name="editIscrizioneIdIter" class="input" type="number" value="${escapeAttr(iscrizione.id_iter)}"></td>
        <td>
            <button class="button is-small is-success" type="button" onclick="saveIscrizioneRow('${escapeAttr(iscrizione.anno_associativo)}', '${escapeAttr(iscrizione.id_persona)}')">Salva</button>
            <button class="button is-small is-light ml-2" type="button" onclick="cancelIscrizioneRow()">Annulla</button>
        </td>
    `;
}

function cancelIscrizioneRow() {
    iscrizioneEditingRowKey = null;
    setIscrizioneCreateFormEnabled(true);
    setIscrizioneInlineStatus('', 'info');
    renderIscrizioni(iscrizioneCache);
}

async function saveIscrizioneRow(anno, idPersona) {
    const row = findIscrizioneRow(anno, idPersona);
    if (!row) return;

    const approvazioneInput = row.querySelector('input[name="editIscrizioneApprovazione"]');
    const pagamentoInput = row.querySelector('input[name="editIscrizioneIdPagamento"]');
    const unitaInput = row.querySelector('input[name="editIscrizioneIdUnita"]');
    const iterInput = row.querySelector('input[name="editIscrizioneIdIter"]');

    if (!pagamentoInput || !unitaInput || !iterInput) return;

    const payload = {
        anno_associativo: anno,
        id_persona: idPersona,
        approvazione_capo: approvazioneInput ? approvazioneInput.checked : false,
        id_pagamento: pagamentoInput.value.trim(),
        id_unita: unitaInput.value.trim(),
        id_iter: iterInput.value.trim(),
    };

    try {
        const saveButton = row.querySelector('button.is-success');
        const cancelButton = row.querySelector('button.is-light');
        if (saveButton) saveButton.disabled = true;
        if (cancelButton) cancelButton.disabled = true;
        setIscrizioneInlineStatus('Salvataggio in corso...', 'info');

        const result = await apiRequest('PUT', API_ISCRIZIONE, payload);
        showResponse(result);
        iscrizioneEditingRowKey = null;
        setIscrizioneCreateFormEnabled(true);
        setIscrizioneInlineStatus('Iscrizione aggiornata correttamente.', 'info');
        fetchIscrizioni();
    } catch (error) {
        handleFetchError(error);
        setIscrizioneInlineStatus('Errore durante il salvataggio. Riprova.', 'error');
    }
}

async function deleteIscrizioneRow(anno, idPersona) {
    if (!anno || !idPersona) return;
    if (!confirm(`Eliminare definitivamente l'iscrizione ${anno} / ${idPersona}?`)) return;

    try {
        const result = await apiRequest('DELETE', API_ISCRIZIONE, { anno_associativo: anno, id_persona: idPersona });
        showResponse(result);
        fetchIscrizioni();
    } catch (error) {
        handleFetchError(error);
    }
}

function setIscrizioneCreateFormEnabled(enabled) {
    const submitButton = getById('iscrizioneSubmitButton');
    const resetButton = getById('iscrizioneResetButton');
    const fields = [
        'iscrizioneAnno',
        'iscrizioneApprovazioneCapo',
        'iscrizioneIdPersona',
        'iscrizioneIdPagamento',
        'iscrizioneIdUnita',
        'iscrizioneIdIter',
    ];

    if (submitButton) submitButton.disabled = !enabled;
    if (resetButton) resetButton.disabled = !enabled;

    fields.forEach(id => {
        const input = getById(id);
        if (input) input.disabled = !enabled;
    });
}

async function fetchIscrizioni() {
    if (iscrizioneEditingRowKey) {
        setIscrizioneInlineStatus('Completa o annulla la modifica in corso prima di aggiornare la lista.', 'warning');
        return;
    }

    try {
        const data = await apiRequest('GET', API_ISCRIZIONE);
        renderIscrizioni(data);
        showResponse(data);
    } catch (error) {
        handleFetchError(error);
    }
}

async function submitIscrizioneForm(event) {
    event.preventDefault();

    const payload = {
        anno_associativo: getValue('iscrizioneAnno').trim(),
        approvazione_capo: getChecked('iscrizioneApprovazioneCapo'),
        id_persona: getValue('iscrizioneIdPersona').trim(),
        id_pagamento: getValue('iscrizioneIdPagamento').trim(),
        id_unita: getValue('iscrizioneIdUnita').trim(),
        id_iter: getValue('iscrizioneIdIter').trim(),
    };

    try {
        const method = iscrizioneFormMode === 'edit' ? 'PUT' : 'POST';
        const result = await apiRequest(method, API_ISCRIZIONE, payload);
        showResponse(result);
        resetForm('iscrizioneForm');
        setIscrizioneFormMode('create');
        fetchIscrizioni();
    } catch (error) {
        handleFetchError(error);
    }
}

function initIscrizionePage() {
    const refreshButton = getById('refreshButton');
    const iscrizioneForm = getById('iscrizioneForm');
    const resetButton = getById('iscrizioneResetButton');

    if (!refreshButton || !iscrizioneForm || !resetButton) return;

    refreshButton.addEventListener('click', fetchIscrizioni);
    iscrizioneForm.addEventListener('submit', submitIscrizioneForm);
    resetButton.addEventListener('click', () => {
        resetForm('iscrizioneForm');
        setIscrizioneFormMode('create');
    });
    setIscrizioneFormMode('create');
    fetchIscrizioni();
}

window.addEventListener('DOMContentLoaded', initIscrizionePage);
